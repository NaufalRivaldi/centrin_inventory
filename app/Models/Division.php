<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Division extends Model
{
    protected $table = 'divisions';
    protected $guarded = [];

    // Relationship
    public function computer_divisions(){
        return $this->hasMany('App\Models\ComputerDivision', 'division_id');
    }

    public function computer_softwares(){
        return $this->hasMany('App\Models\ComputerSoftware', 'software_id');
    }

    public function software_divisions(){
        return $this->hasMany('App\Models\SoftwareDivision', 'software_id');
    }
}
