<?php

namespace App\Http\Controllers;

use App\Notifications\NotifyInvitation;
use App\Ship;
use App\ShipUser;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\DB;

class InvitationController extends Controller
{
	public function edit ($id) {
		$ship = Ship::find($id);
		$users = $ship->users;
		return view('invitation.edit', compact( 'users', 'id'));
	}

	public function destroy($id, $ship_id)
	{
		$ship = Ship::find($ship_id);
		$ship->users()->detach($id);

		return redirect()->back();
	}

	/**
	 * @param User $user
	 * @param Ship $ship
	 * @param NotifyInvitation $notification
	 *
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function action(User $user, Ship $ship, $notification) {
		return view('invitation.action', compact( 'user', 'ship', 'notification'));
	}

	public function decision($status, User $user, Ship $ship, $notification) {
		$recipient = DB::table('notifications')->find($notification);
		DB::table('ship_user')->where([['user_id', $recipient->notifiable_id], ['ship_id', $ship->id]])->update(array('status' => $status));
		DB::table('notifications')->where('id', $notification)->delete();

		return redirect()->route( 'dashboard');
	}
}
