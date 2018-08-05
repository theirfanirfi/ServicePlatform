<?php

namespace App\Http\Controllers;

use App\Http\Requests\ShipFeedRequest;
use App\ShipFeed;
use App\ShipFeedComment;
use App\User;
use App\Roles;
use App\Ship;
use Illuminate\Http\Request;
use App\DataTables\ShipsDataTable;
use App\Http\Requests\ShipRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;

use App\Notifications\NotifyInvitation;
use App\ShipUser;
use Illuminate\Support\Facades\Notification;

class ShipController extends Controller
{
    public function Ships(ShipsDataTable $dataTable){
	    $user = Auth::user();
	    $user_role = $user->roles->first()->id;

//	    return $user_role;

	    if($user_role === 3 || $user_role === 4){
		    $ship_feeds = ShipFeed::where('user_id', $user->id)->with('user')->orderBy('created_at', 'desc')->limit(5)->get();
		    return $dataTable->render('ships', ['latest_feeds' => $ship_feeds]);
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
				    foreach ($selected_sellers as $seller) {
						$ship_user = ShipUser::create([
							'ship_id' => $ship->id,
							'user_id' => $seller
						]);
					}
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

    public function ViewShip($ship_id){
        $ship = Ship::find($ship_id);
        if(!$ship){
            return redirect()->route('ships');
        }
	    $users = $ship->users;
	    $share_users = $ship->shareUsers;

//        dd($ship->user_id);
        return view('view_ship', ['ship' => $ship, 'users' => $users,'share_users'=>$share_users]);
    }

    public function StoreImageShip(Request $request){
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

    public function StoreFeedShip($ship_id, ShipFeedRequest $request){
        $ship = ShipFeed::create([
            'ship_id' => $ship_id,
            'user_id' => \auth()->user()->id,
            'post' => $request->input('post'),
        ]);
        $ship->load('user');
        $ship->load('comments.user');
        return response()->json($ship);
    }

    public function GetShipFeed($ship_id, $limit = null){
        $feed = ShipFeed::where('ship_id', $ship_id)
            ->where('user_id', \auth()->user()->id)
            ->with('user')
            ->with('comments.user')
            ->with('comments.childComments.user');
        if($limit){
            $feed->limit($limit);
        }
        $feeds = $feed->orderBy('created_at', 'DESC')->get();
        return response()->json(
            $feeds
        );
    }

    public function GetShipFeedByUser(){
        $ships = Ship::select('id', 'user_id')->where('user_id', \auth()->user()->id)->get();
        $limit = 3;
        $helper = 0;
        $result = [];
        foreach($ships as $ship){
            $result[] = $this->GetShipFeed($ship->id, 5)->getData();
            if($helper >= $limit){
                break;
            }
            $helper++;
        }
        return response()->json(
            $result[0] ?? []
        );
    }

    public function GetShipFeedComments($feed_id){
        return response()->json(
            ShipFeedComment::where('feed_id', $feed_id)->orderBy('created_at', 'DESC')->with('childComments')->get()
        );
    }

    public function ShipCommentFeed(Request $request){
        $comment = new ShipFeedComment();
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

       $count = ShipFeed::where('id', '>', $request->input('last_feed'))->count();

       return response()->json(
            ['count' => $count]
        );
    }


}
