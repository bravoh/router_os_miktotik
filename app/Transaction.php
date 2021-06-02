<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $guarded = [];

    public function updateStatus($new_status){
        $this->status = $new_status;
        $this->save();
    }

    public function subscription(){
        return $this->hasOne(Subscription::class);
    }
}
