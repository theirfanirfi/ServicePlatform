<?php

namespace App\Http\Controllers;

use App\Project;
use App\ProjectInvitation;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProjectInvitationController extends Controller
{
    public function edit ($id) {
        $project = Project::find($id);
        $invitations = $project->invitations()->where('main', '<>', 1)->get();
        return view('invitation.project.edit', compact('invitations', 'id', 'project'));
    }

    public function destroy($id, $project_id)
    {
        ProjectInvitation::where(['project_id' =>$project_id, 'invited_user_id' => $id])->delete();
        return redirect()->back();
    }

    /**
     * @param User $user
     * @param Project $project
     * @param ProjectInvitation $notification
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function action(User $user, Project $project, $notification) {
        return view('invitation.project.action', compact( 'user', 'project', 'notification'));
    }

    public function decision($status, User $user, Project $project, $notification) {
        $recipient = DB::table('notifications')->find($notification);
        DB::table('project_invitations')->where(['invited_user_id' => $recipient->notifiable_id, 'project_id' => $project->id])->update(array('status' => $status));
        DB::table('notifications')->where('id', $notification)->delete();

        return redirect()->route('projects');
    }

    public function editPermissions($project_id, $invited_user_id, Request $request){
        $invitation = ProjectInvitation::where(['project_id' => $project_id, 'invited_user_id' => $invited_user_id])->first();
        if($invitation) {
            $invitation->view_files = false;
            if ($request->input('view_files')) {
                $invitation->view_files = true;
            }
            $invitation->upload_files = false;
            if ($request->input('upload_files')) {
                $invitation->upload_files = true;
            }
            $invitation->save();
        }
        return back();
    }
}
