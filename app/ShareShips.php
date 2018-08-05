<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ShareShips extends Model
{
    //

    public function details(){
        return $this->belongsTo('App\Ship','ship_id','id');
    }

    public function userDetails(){
        return $this->belongsTo('App\User','user_id','id');
    }

    public function shareUserDetails(){
        return $this->belongsTo('App\User','to_user_id','id');
    }
}
