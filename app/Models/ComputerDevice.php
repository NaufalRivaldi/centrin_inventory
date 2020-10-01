<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ComputerDevice extends Model
{
    protected $table = 'computer_devices';
    protected $guarded = [];

    // Relationship
    public function computer(){
        return $this->belongsTo('App\Models\Computer', 'computer_id');
    }

    public function device(){
        return $this->belongsTo('App\Models\Device', 'device_id');
    }
}
