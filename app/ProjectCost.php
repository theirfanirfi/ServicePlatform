<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProjectCost extends Model
{
    protected $guarded = [];

    public function project(){
        return $this->belongsTo(Project::class);
    }

    public function fromUser(){
        return $this->project->user;
    }
}
