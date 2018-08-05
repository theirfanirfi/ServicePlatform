<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
		$data=$request->all();
		Validator::make($data, [
            'name' => 'required|string',
            'profile' => 'mimes:jpeg,jpg,png|max:5000',
        ]);
		
		$datas['name']=$data['name'];
		$datas['email']=$data['email'];
		if(isset($data['password']) && $data['password']!=''){
			$datas['password']=$data['password'];
		}else{
			$datas['password']=$data['prev_pass'];
		}
		$datas['contact']=$data['contact'];
		$datas['address']=$data['address'];
		
		if($request->file('profile')){
			$image=$request->file('profile');
			$fileOriginalName=$image->getClientOriginalName();
			$destinationPath =public_path().'/uploads/profiles/'.$id;
			$fileName=time().'_'.$image->getClientOriginalName();
			$image->move($destinationPath,$fileName);
			$image_path=url('/').'/public/uploads/profiles/'.$id.'/'.$fileName;
			$datas['profile']=$image_path;
		}else{
			$datas['profile']=$data['prev_profile'];
		}
		
		$updateProfile=\App\User::where('id',$id)->update($datas);
		
		if($updateProfile){
			return redirect('dashboard')->with('success','Profile update successfully.');
		}else{
			return redirect('dashboard')->with('error','Something went wrong!!!, Please try again.');
		}
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
