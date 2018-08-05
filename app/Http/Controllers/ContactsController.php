<?php

namespace App\Http\Controllers;

use App\Contacts;
use App\Organisation;
use App\User;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ContactsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $organisationList = Organisation::where('is_deleted','=',0)->get();
        return view('contacts',compact('organisationList'));
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
            'surname'=>'required',
          //  'company'=>'required',
            'email'=>'required|email|unique:contacts',
            'phone'=>'required',
            'address'=>'required|string|min:5|max:255',
            'contact'=>'required|in:Agent,Forwarder',
            'organisation_id'=>'required|exists:organisation,id',
        ]);

        $contacts = new Contacts();
        $contacts->name = $request->name;
        $contacts->user_id = Auth::user()->id;
        $contacts->surname = $request->surname;
        // $contacts->company = $request->company;
        $contacts->email = $request->email;
        $contacts->phone = $request->phone;
        $contacts->address = $request->address;
        $contacts->contact = $request->contact;
        $contacts->organisation_id = $request->organisation_id;

        if($contacts->save()){
            return redirect()->route('form.contacts.contactList')->with('message','Contact Detail Add!');
        }

        return redirect()->back()->with('error','Contact Details Not Added');

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
        $contacts = Contacts::find($id);
        $organisationList = Organisation::where('is_deleted','=',0)->get();

        return view('update_contacts',compact('contacts'),compact('organisationList'));
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
        $this->validate($request,[
            'name'=>'required',
            'surname'=>'required',
           // 'company'=>'required',
            'phone'=>'required',
            'address'=>'required|string|min:5|max:255',
            'organisation_id'=>'required|exists:organisation,id',
        ]);

        $contacts = Contacts::find($id);

        if($contacts){

            $contacts->name = $request->name;
            $contacts->user_id = Auth::user()->id;
            $contacts->surname = $request->surname;
        //    $contacts->company = $request->company;
            $contacts->email = $request->email;
            $contacts->phone = $request->phone;
            $contacts->address = $request->address;
            $contacts->contact = $request->contact;
            $contacts->organisation_id = $request->organisation_id;
            $contacts->save();

            return redirect()->route('form.contacts.contactList')->with('message','Contact Update Success!');
        }
        return redirect()->back()->with('error','Contact Details Not Update.');
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
        $contacts = Contacts::find($id);

        $contacts->delete();

        return redirect()->route('form.contacts.contactList')->with('message','Contact Remove Success!');
    }

    public function showContactDetail(){

        $userId = Auth::user()->id;

        $contacts = Contacts::with('organisation')->where('user_id','=',$userId)->get();

        return view('contact_list',compact('contacts'));
    }

    public function getAllUserList(){

        return User::all();
    }
}
