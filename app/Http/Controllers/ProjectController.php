<?php

namespace App\Http\Controllers;

use App\DataTables\ProjectsDataTable;
use App\Http\Requests\ProjectFeedRequest;
use App\Http\Requests\ProjectFormRequest;
use App\Project;
use App\ProjectCost;
use App\ProjectFeed;
use App\ProjectFeedComment;
use App\ProjectFile;
use App\ProjectInvitation;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;

class ProjectController extends Controller
{

    public function Projects(ProjectsDataTable $dataTable){
        return $dataTable->render('projects');
    }

    public function FormProject($project_id){
        $project = Project::with('invitations')->findOrNew($project_id);
        $sellers = User::whereHas('roles', function($query) { $query->where('name', '=', 'seller'); })->get();
        $buyers = User::whereHas('roles', function($query) { $query->where('name', '=', 'buyer'); })->get();
        $users_invited_id = $project->invitations()->pluck('invited_user_Id')->toArray();

        return view('form_project', [
            'project' => $project,
            'sellers' => $sellers,
            'buyers' => $buyers,
            'users_invited_id' => $users_invited_id,
        ]);
    }

    public function StoreProject(ProjectFormRequest $request){
        $user = auth()->user();
        $project = Project::find($request->input('project_id'));
        $is_new = false;
        if(!$project) {
            $is_new = true;
        }
        if($is_new || (!$is_new && $project->canDelete())) {
            $project = Project::updateOrCreate(['id' => $request->input('project_id')], [
                'user_id' => $user->id,
                'ship_id' => $request->input('ship_id'),
                'name' => $request->input('name'),
                'description' => $request->input('description'),
                'port' => $request->input('port'),
                'eta' => $request->input('eta'),
                'etb' => $request->input('etb'),
                'etd' => $request->input('etd'),
                'date' => $request->input('date'),
            ]);
        }

        if($project){
            $invitation_from = $request->input('invitation');
            if($invitation_from) {
                $invitation_project = ProjectInvitation::where(['invited_user_id' => $invitation_from, 'project_id' => $project->id])->first();
                $invitation = [];
                if($invitation_project){
                    $invitation['id'] = $invitation_project->id;
                }
                $invitation['project_id'] = $project->id;
                $invitation['user_id'] = $user->id;
                $invitation['invited_user_id'] = $invitation_from;
                $invitation['main'] = true;
                $invitation['view_files'] = true;
                $invitation['upload_files'] = true;
                $invited = $project->invitations()->sync([$invitation]);
                if(isset($invited['created'][0][0])){
                    $project_invitation = ProjectInvitation::find($invited['created'][0][0]);
                    if($project_invitation->status === 0) {
                        Notification::send($project_invitation->user_invited, new \App\Notifications\ProjectInvitation($user, $project));
                    }
                }
            }

            $files = $request->file('files');
            $destinationPath = 'uploads/project/' . $project->id;
            $files_insert = [];
            $helper = 0;
            if($request->input('files')) {
                foreach ($request->input('files') as $key => $file) {
                    $OldFile = ProjectFile::where('filename', $file)->first();
                    if($OldFile) {
                        $files_insert[$helper]['id'] = $OldFile->id;
                        $files_insert[$helper]['project_id'] = $OldFile->project_id;
                        $files_insert[$helper]['user_id'] = $OldFile->user_id;
                        $files_insert[$helper]['filename'] = $OldFile->getOriginal('filename');
                        $helper++;
                    }
                }
            }
            if($files) {
                foreach($files as $key => $file) {
                    $filename = str_random().'_'.$file->getClientOriginalName();
                    if ($file->move($destinationPath, $filename)) {
                        $files_insert[$helper]['project_id'] = $project->id;
                        $files_insert[$helper]['user_id'] = $user->id;
                        $files_insert[$helper]['filename'] = $filename;
                        $helper++;
                    }
                }
            }
            $project->files()->sync($files_insert);
        }

        return redirect()->route('form.project', $project->id);
    }

    public function deleteProject($project_id){
        Project::find($project_id)->delete();
        return back();
    }

    public function closeProject($project_id){
        $project = Project::find($project_id);
        if($project){
            $project->closed = true;
            $project->save();
        }
        return back();
    }

    public function viewProject($project_id){
        $project = Project::findOrFail($project_id);
        return view('view_project', ['project' => $project]);
    }

    public function StoreImageFeed(Request $request){
        $image = $request->file('upload');
        $fileOriginalName =  $image->getClientOriginalName();
        $destinationPath = public_path().'/uploads/feed/';
        $image_name = time().'_'.$image->getClientOriginalName();
        $image_path = asset('/uploads/feed/'.$image_name);
        $status = false;
        if($image->move($destinationPath, $image_name)){
            $status = true;
        }
        return response()->json(
            [
                'url' => $image_path,
                "uploaded" => $status,
            ]
        );
    }

    public function feedsProject($project_id){
        $feed = ProjectFeed::where('project_id', $project_id)
            ->with('user')
            ->with('comments.user')
            ->with('comments.childComments.user');
        $feeds = $feed->orderBy('created_at', 'DESC')->get();
        return response()->json(
            $feeds
        );
    }

    public function StoreFeed($project_id, ProjectFeedRequest $request){
        $feed = ProjectFeed::create([
            'project_id' => $project_id,
            'user_id' => \auth()->user()->id,
            'post' => $request->input('post'),
        ]);
        $feed->load('user');
        $feed->load('comments.user');
        return response()->json($feed);
    }

    public function StoreFeedReply(Request $request){
        $comment = new ProjectFeedComment();
        $comment->feed_id = $request->input('feed_id');
        $comment->user_id = \auth()->user()->id;
        if($request->input('reply_id') !== 'null') {
            $comment->reply_id = $request->input('reply_id');
        }
        $comment->comment = $request->input('comment');
        $comment->save();

        return response()->json(
            $comment ? true : false
        );
    }

    public function countNewsFeeds(Request $request){
        if(!$request->has('last_feed'))
        {
            return response()->json(
                false
            );
        }
        $count = ProjectFeed::where('id', '>', $request->input('last_feed'))->count();

        return response()->json(
            ['count' => $count]
        );
    }

    public function formCosts(Request $request){
        $cost = ProjectCost::updateOrCreate(['id' => $request->input('id')], [
            'project_id' => $request->input('project_id'),
            'name' => $request->input('name'),
            'quantity' => $request->input('quantity'),
            'amount' => $request->input('amount'),
        ]);

        $cost->load(['project' => function($query){
            return $query->select('id', 'user_id');
        }, 'project.user' => function($query){
            return $query->select('id', 'name');
        }]);
        return response()->json( $cost );
    }

    public function getCosts($project_id){
        $costs = ProjectCost::with(['project' => function($query){
            return $query->select('id', 'user_id');
        }, 'project.user' => function($query){
            return $query->select('id', 'name');
        }, 'project.invitations' => function($query){
            return $query->select('id', 'project_id')->where(['invited_user_id' => auth()->user()->id, 'main' => true]);
        }])->where('project_id', $project_id)->get();
        return response()->json($costs);
    }

    public function actionCost(Request $request){
        $Cost = ProjectCost::find($request->input('cost_id'));
        $Cost->status = $request->input('type');
        return response()->json($Cost->save());
    }

    public function removeCost(Request $request){
        $Cost = ProjectCost::find($request->input('cost_id'));
        if($Cost) {
            if ($Cost->status !== 0) {
                return response()->json(['status' => false, 'msg' => 'The buyer already has accepted or declined this cost.']);
            }
            return response()->json(['status' => $Cost->delete()]);
        }
        return response()->json(['status' => true]);
    }
}
