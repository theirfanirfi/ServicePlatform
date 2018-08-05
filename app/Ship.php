<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Ship extends Model
{
    //
    protected $guarded = [];

	public function users()
	{
		return $this->belongsToMany('App\User')->withPivot('ship_id', 'user_id', 'status')->as('invited')->withTimestamps();
	}

    public function feeds()
    {
        return $this->hasMany(ShipFeed::class);
    }

    public function shareUsers(){

	    return $this->hasMany(ShareShips::class,'ship_id','id')->with('shareUserDetails')->where('status','=',1);
    }

}