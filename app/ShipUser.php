<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class ShipUser extends Model
{
	use Notifiable;
    //
	protected $table = 'ship_user';
	protected $fillable = ['ship_id', 'user_id'];
}
