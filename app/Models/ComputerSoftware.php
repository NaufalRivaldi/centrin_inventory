<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ComputerSoftware extends Model
{
    protected $table = 'computer_softwares';
    protected $guarded = [];

    // Relationship
    public function computer(){
        return $this->belongsTo('App\Models\Computer', 'computer_id');
    }

    public function software(){
        return $this->belongsTo('App\Models\Software', 'software_id');
    }

    public function division(){
        return $this->belongsTo('App\Models\Division', 'division_id');
    }
}
