<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $guarded = [];

    public function plans(){
        return $this->hasMany(PlanUser::class);
    }

    public function active_plan(){
        return $this->plans()->latest()->first();
    }

    public function subscriptions(){
        return $this->hasMany(Subscription::class);
    }
}
