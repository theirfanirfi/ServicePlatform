<?php

namespace App\Http\Controllers;

use App\DataTables\ShipsDataTable;
use App\Http\Requests\ShipRequest;
use App\Notifications\NotifyInvitation;
use App\ShareShips;
use App\Ship;
use App\ShipUser;
use Illuminate\Http\Request;
use App\User;
use App\Roles;
use App\Schedule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Notification;

class DashboardController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        /* return view('dashboard'); */

        $user = Auth::user();
        $user_role= $user->roles->first()->id;

        $ships_request = ShareShips::where(['to_user_id'=>$user->id])
            ->with('details','userDetails')
            ->get();

        if($user_role==3 || $user_role==4){
            return view('dashboard',compact('ships_request'));
        }

    }

    public function Ships(ShipsDataTable $dataTable){
        $user = Auth::user();
        $user_role = $user->roles->first()->id;

        $userList = User::all();
//	    return $user_role;

        if($user_role === 3 || $user_role === 4){
            return $dataTable->render('ships',compact('userList'));
        }
        return redirect()->route('dashboard');
    }

    public function FormShip($ship_id){
        $user = Auth::user();
        $ship = Ship::firstOrNew(['id' => $ship_id, 'user_id' => $user->id]);
        $user_role = $user->roles->first()->id;

//        $sellers = Roles::with('users')->where('name', '=', 'seller')->get();
	    $sellers = User::whereHas('roles', function($query) { $query->where('name', '=', 'seller'); })->get();
	    $buyers = User::whereHas('roles', function($query) { $query->where('name', '=', 'buyer'); })->get();


	    if($user_role === 3){
            return view('form_ship', ['ship' => $ship, 'sellers' => $sellers, 'toInvite' => 'seller']);
        } elseif($user_role === 4) {
		    return view('form_ship', ['ship' => $ship, 'buyers' => $buyers, 'toInvite' => 'buyer']);
	    }
        return redirect()->route('dashboard');
    }

    public function StoreShip(ShipRequest $request){

        $user = Auth::user();
        $ship = Ship::updateOrCreate(['id' => $request->input('ship_id')], [
            'user_id' => $user->id,
            'imo' => $request->input("imo"),
            'name' => $request->input("name"),
            'mmsi' => $request->input("mmsi"),
            'vessel' => $request->input("vessel"),
            'gross_tonnage' => $request->input("gross_tonnage"),
            'build' => $request->input("build"),
            'flag' => $request->input("flag"),
            'home_port' => $request->input("home_port")
        ]);


        if($ship){
	        if(Input::has('seller')) {
		        $selected_sellers = $request->input('seller');
		        if(count( $selected_sellers) > 0) {
			        /*foreach ($selected_sellers as $seller) {
						$ship_user = ShipUser::create([
							'ship_id' => $ship->id,
							'user_id' => $seller
						]);
					}*/
					$ship->users()->attach($selected_sellers);
			        Notification::send($ship->users, new NotifyInvitation($user, $ship));
		        }
	        }
            return redirect()->route('ships');
        }
        return redirect()->route('formShip', $request->id ?? 'new');
    }

    public function deleteShip($ship_id){
        $ship = Ship::find($ship_id);
        if($ship){
        	$ship->users()->detach();
            $ship->delete();
        }
        return redirect()->route('ships');
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
        //
    }
	
	public function schedules($id)
	{
		$ship = Ship::find($id);
		$schedules = Schedule::where(['ship_id'=>$id])->get();
		$data['ship'] = $ship;
		$data['schedules'] = $schedules;
		return view('schedules',$data);
	}
	
public function FormSchedule(Request $req)
	{
		$destination = $req->input('destination');
		$etb_date = $req->input('etb_date');
		$etd_date = $req->input('etd_date');
		$eta_date = $req->input('eta_date');
		$ship_id = $req->input('ship_id');
		$s = new Schedule();
		$s->destination = $destination;
		$s->etb_date = $etb_date;
		$s->etd_date = $etd_date;
		$s->eta_date = $eta_date;
		$s->ship_id = $ship_id;
		if($s->save())
		{
			echo "1";
		}
		else {
			echo "0";
		}
	}

	public function fetchScheduleTableRows($id)
	{
		$schedules = Schedule::where(['ship_id' => $id])->get();
		$data['schedules'] = $schedules;
		return view('table_rows',$data);
	}
	
	public function deleteSchedule($id)
	{
		$s = Schedule::find($id);
		if($s->delete())
		{
			echo "1";
		}
		else
		{
			echo "0";
		}
	}
	
	public function getSchedule($id)
	{
		$s = Schedule::find($id);
		return response()->json($s);
	}
	
	public function updateSchedule(Request $req)
	{
		$destination = $req->input('destination');
		$etb_date = $req->input('etb_date');
		$etd_date = $req->input('etd_date');
		$eta_date = $req->input('eta_date');
		$sid = $req->input('sid');
		$s = Schedule::find($sid);
		$s->destination = $destination;
		$s->etb_date = $etb_date;
		$s->etd_date = $etd_date;
		$s->eta_date = $eta_date;
		if($s->save())
		{
			echo "1";
		}
		else {
			echo "0";
		}
	}
	
}
