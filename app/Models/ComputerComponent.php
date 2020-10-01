<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ComputerComponent extends Model
{
    protected $table = 'computer_components';
    protected $guarded = [];

    // Relationship
    public function computer(){
        return $this->belongsTo('App\Models\Computer', 'computer_id');
    }
}
