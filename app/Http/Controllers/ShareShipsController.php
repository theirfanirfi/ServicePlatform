<?php

namespace App\Http\Controllers;

use App\ShareShips;
use App\ShipUser;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ShareShipsController extends Controller
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
     * @param  \App\ShareShips  $shareShips
     * @return \Illuminate\Http\Response
     */
    public function show(ShareShips $shareShips)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ShareShips  $shareShips
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request,$ship_id)
    {
        $userList = User::all();
        $share_users = ShareShips::where([['ship_id','=',$ship_id],['status','=',1]])->get();

        $already_share = array();
        if ($share_users){
            $already_share = array_column($share_users->toArray(),'to_user_id');
        }

        return view('share_ship',compact('userList','ship_id','already_share'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ShareShips  $shareShips
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$shipsId)
    {
        try{
            $shareShips = new ShareShips();
            $shareShips->user_id = Auth::user()->id;
            $shareShips->to_user_id = $request->user_id;
            $shareShips->ship_id = $shipsId;
            $shareShips->save();

            return redirect()->route('ships')->with('success','Ship Share Success');
        }catch (\Exception $e){
            return redirect()->route('share_ship.edit',$shipsId)->with('success','Ship Share Success');
        }
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ShareShips  $shareShips
     * @return \Illuminate\Http\Response
     */
    public function destroy(ShareShips $shareShips)
    {
        //
    }

    public function shipRequestAccept(Request $request,$ship_id){

        $shareShips = ShareShips::find($ship_id);
        $shareShips->status = 1;
        $shareShips->save();

        $share_user = new ShipUser();
        $share_user->ship_id = $ship_id;
        $share_user->user_id = Auth::user()->id;
        $share_user->status = 1;
        $share_user->save();


        return redirect()->back()->with('success','Ship Request is accepted!');
    }

    public function shipRequestReject(Request $request,$ship_id){

        $shareShips = ShareShips::find($ship_id);
        $shareShips->status = 2;
        $shareShips->save();

        return redirect()->back()->with('error','Ship Request is Reject!');
    }
}
