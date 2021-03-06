<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Computer extends Model
{
    protected $table = 'computers';
    protected $guarded = [];

    // Relationship
    public function computer_components(){
        return $this->hasMany('App\Models\ComputerComponent', 'computer_id');
    }

    public function computer_component_memories(){
        return $this->hasMany('App\Models\ComputerComponent', 'computer_id')->where('component_type', 'Memory');
    }

    public function computer_component_harddrives(){
        return $this->hasMany('App\Models\ComputerComponent', 'computer_id')->where('component_type', 'Harddrive');
    }

    public function computer_devices(){
        return $this->hasMany('App\Models\ComputerDevice', 'computer_id');
    }

    public function computer_divisions(){
        return $this->hasOne('App\Models\ComputerDivision', 'computer_id');
    }

    public function computer_histories(){
        return $this->hasMany('App\Models\ComputerHistory', 'computer_id');
    }

    public function computer_softwares(){
        return $this->hasMany('App\Models\ComputerSoftware', 'computer_id');
    }
}
