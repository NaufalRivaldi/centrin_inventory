<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ComputerHistory extends Model
{
    protected $table = 'computer_histories';
    protected $guarded = [];

    // Relationship
    public function computer(){
        return $this->belongsTo('App\Models\Computer', 'computer_id');
    }
}
