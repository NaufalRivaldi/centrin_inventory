<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    protected $table = 'devices';
    protected $guarded = [];

    // Relationship
    public function computer_devices(){
        return $this->hasMany('App\Models\ComputerDevice', 'device_id');
    }

    public function device_divisions(){
        return $this->hasOne('App\Models\DeviceDivision', 'device_id');
    }
}
