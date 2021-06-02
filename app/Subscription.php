<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    protected $guarded = [];

    public function customer(){
        return $this->belongsTo(Customer::class);
    }

    public function putDown(){
        $this->status = 'downed';
        $this->downed_on = date('Y-m-d h:i:s');
        $this->save();
    }
}
