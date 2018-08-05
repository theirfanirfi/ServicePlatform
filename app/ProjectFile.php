<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProjectFile extends Model
{

    protected $guarded = [];

    public function getFilenameAttribute($value){
        $filename = explode('_', $value, 2);
        return $filename[1];
    }
}
