<?php

namespace App\Http\Controllers;

use App\Subscription;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SubscriptionController extends Controller
{
    public function index(){
        $subscriptions = DB::table('subscriptions')
        ->select('subscriptions.*','customers.name')
        ->join('customers','subscriptions.customer_id','=','customers.id')
        ->orderBy('id','desc')
        ->get()->toArray();
        /*echo "<pre>";
        print_r($subscriptions);die();*/
        return view('subscription.index',compact('subscriptions'));
    }

}
