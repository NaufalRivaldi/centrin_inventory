<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ComputerDivision extends Model
{
    protected $table = 'computer_divisions';
    protected $guarded = [];

    // Relationship
    public function computer(){
        return $this->belongsTo('App\Models\Computer', 'computer_id');
    }

    public function division(){
        return $this->belongsTo('App\Models\Division', 'division_id');
    }
}
