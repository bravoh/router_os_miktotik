<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sms extends Model
{
    protected $guarded = [];

    public function getRecipientsAttribute(){
        //Get recipients
        $recipients = json_decode($this->recipient);

        if ($this->recipient_type != "select"){
            $recipients = array();

            switch ($this->recipient_type){
                case "all":
                    //all customers db
                    foreach (Customer::all() as $customer){
                        $recipients[] = $customer->phone;
                    }
                    break;
                default:
                    //default action
                    $subscription = explode("by_",$this->recipient_type);
                    $subs = Subscription::wherePlan($subscription[1])->get();
                    foreach ($subs as $sub){
                        $recipients[] = $sub->customer->phone;
                    }
            }
        }

        return array_unique($recipients);
    }
}
