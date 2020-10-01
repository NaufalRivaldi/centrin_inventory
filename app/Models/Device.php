<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    protected $table = 'devices';
    protected $guarded = [];

    // Relationship
    public function computerDevices(){
        return $this->hasMany('App\Models\ComputerDevice', 'device_id');
    }
}
