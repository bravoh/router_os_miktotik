<?php

namespace App\Http\Controllers;

use App\Sms;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;

class SmsController extends Controller
{
    public function index(){
        $sms = Sms::orderBy('id','desc')->get();
        return view('sms.index',compact('sms'));
    }

    public function runScheduler(){
        return Artisan::call("scheduledsms:send");
    }

}
