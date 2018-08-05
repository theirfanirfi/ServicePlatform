<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contacts extends Model
{
    //

    public function organisation(){

        return $this->belongsTo('App\Organisation','organisation_id','id')->where('is_deleted','=',0);
    }
}
