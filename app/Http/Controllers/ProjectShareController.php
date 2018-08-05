<?php

namespace App\Http\Controllers;

use App\Project;
use App\ProjectInvitation;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;

class ProjectShareController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ShareShips  $share
     * @return \Illuminate\Http\Response
     */
    public function show(ProjectInvitation $share)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ShareShips  $shareShips
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $project_id)
    {
        $userList = User::all();
        $share_users = ProjectInvitation::where(['project_id' => $project_id, 'status' => 1])->get();

        $already_share = array();
        if ($share_users){
            $already_share = array_column($share_users->toArray(), 'invited_user_id');
        }

        return view('project_share', compact('userList', 'project_id', 'already_share'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ShareShips  $shareShips
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $project_id)
    {
        try{
            $user = Auth::user();
            $share = new ProjectInvitation();
            $share->user_id = $user->id;
            $share->invited_user_id = $request->input('user_id');
            $share->project_id = $project_id;
            $share->save();

            $Project = Project::find($project_id);

            Notification::send($share->user_invited, new \App\Notifications\ProjectInvitation($user, $Project));
            return redirect()->route('projects')->with('success','Project Share Success');
        }catch (\Exception $e){
            return redirect()->route('project.invitation.edit', $project_id)->with('success','Project Share Success');
        }
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ProjectInvitation  $share
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProjectInvitation $share)
    {
        //
    }

    public function shipRequestAccept(Request $request, $ship_id){

        $shareShips = ProjectInvitation::find($ship_id);
        $shareShips->status = 1;
        $shareShips->save();

        return redirect()->back()->with('success','Ship Request is accepted!');
    }

    public function shipRequestReject(Request $request,$ship_id){

        $shareShips = ProjectInvitation::find($ship_id);
        $shareShips->status = 2;
        $shareShips->save();

        return redirect()->back()->with('error','Ship Request is Reject!');
    }
}
