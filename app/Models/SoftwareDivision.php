<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SoftwareDivision extends Model
{
    protected $table = 'software_divisions';
    protected $guarded = [];

    // Relationship
    public function software(){
        return $this->belongsTo('App\Models\Software', 'software_id');
    }

    public function division(){
        return $this->belongsTo('App\Models\Division', 'division_id');
    }
}
