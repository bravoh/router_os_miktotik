<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PlanUser extends Model
{
    protected $guarded = [];

    public function customer(){
        return $this->belongsTo(Customer::class);
    }

    public function plan(){
        return $this->belongsTo(Plan::class);
    }
}
