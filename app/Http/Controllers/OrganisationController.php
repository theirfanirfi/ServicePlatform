<?php

namespace App\Http\Controllers;

use App\Contacts;
use App\Organisation;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Contracts\DataTable;

class OrganisationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $userId = Auth::user()->id;

        $contacts = Organisation::where([['user_id','=',$userId],['is_deleted','=',0]])->get();

        return view('organisation_list',compact('contacts'));
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
        $this->validate($request,[
            'name'=>'required',
            'vat_number'=>'required',
            'city'=>'required',
            'phone'=>'required',
            'address'=>'required|string|min:5|max:255',
            'country'=>'required',
            'zip_code'=>'required|min:4|max:7',
        ]);

        $oraganisation = new Organisation();
        $oraganisation->name = $request->name;
        $oraganisation->user_id = Auth::user()->id;
        $oraganisation->vat_number = $request->vat_number;
        $oraganisation->city = $request->city;
        $oraganisation->phone = $request->phone;
        $oraganisation->address = $request->address;
        $oraganisation->country = $request->country;
        $oraganisation->zip_code = $request->zip_code;

        if($oraganisation->save()){
            return redirect()->route('organisation.index')->with('message','Organisation Details Added Success!');
        }

        return redirect()->back()->with('error','Organisation Details Not Added Some error try again!');

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
        $userId = Auth::user()->id;

        $contacts = Organisation::where('user_id','=',$userId);

        return DataTable::of($contacts)->make(true);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $contacts = Organisation::find($id);

        return view('update_organisation',compact('contacts'));
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
        $oraganisation = Organisation::find($id);

        if($oraganisation){

            $oraganisation->name = $request->name;
            $oraganisation->user_id = Auth::user()->id;
            $oraganisation->vat_number = $request->vat_number;
            $oraganisation->city = $request->city;
            $oraganisation->phone = $request->phone;
            $oraganisation->address = $request->address;
            $oraganisation->country = $request->country;
            $oraganisation->zip_code = $request->zip_code;

            $oraganisation->save();

            return redirect()->route('organisation.index')->with('message','Organisation Details Update.');
        }
        return redirect()->back()->with('error','Organisation Details Not Update.');

        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $organisation = Organisation::find($id);

        $organisation->is_deleted = 1;
        $organisation->save();

        return redirect()->route('organisation.index')->with('message','Organisation Deleted Success!');
    }

    public function addOrganisationForm(){

        return view('add_organisation');
    }
}
