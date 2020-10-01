<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DeviceDivision extends Model
{
    protected $table = 'device_divisions';
    protected $guarded = [];

    // Relationship
    public function device(){
        return $this->belongsTo('App\Models\Devices', 'device_id');
    }

    public function division(){
        return $this->belongsTo('App\Models\Divisions', 'division_id');
    }
}
