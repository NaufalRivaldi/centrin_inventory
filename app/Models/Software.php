<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Software extends Model
{
    protected $table = 'softwares';
    protected $guarded = [];

    // Relationship
    public function computer_softwares(){
        return $this->hasMany('App\Models\ComputerSoftware', 'software_id');
    }

    public function software_divisions(){
        return $this->hasOne('App\Models\SoftwareDivision', 'software_id');
    }
}
