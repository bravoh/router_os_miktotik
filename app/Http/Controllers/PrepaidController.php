<?php

namespace App\Http\Controllers;

use App\Plan;
use App\PlanUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class PrepaidController extends Controller
{
    public function index(){
        $items = PlanUser::all();
        return view('planuser.index',compact('items'));
    }

    public function create(){
        if (\request()->isMethod('POST'))
            return $this->save();

        return view('planuser.create');
    }

    public function edit(){
        return view('planuser.edit');
    }

    public function save(){
        $date_now = date("Y-m-d H:i:s");
        $date_only = date("Y-m-d");
        $time = date("H:i:s");
        $plan = Plan::whereId(\request()->plan_id)->first();
        $expiry = date('Y-m-d', strtotime($date_only. ' + '.$plan->validity.' days'));

        PlanUser::updateOrCreate(['id'=>\request()->id],[
            'customer_id' => \request()->customer_id,
            'plan_id' => \request()->plan_id,
            'status' => 'on',
            'target_ip'=>\request()->target_ip,
            'date'=>date("Y-m-d H:i:s"),
            'expiry_date'=>$expiry
        ]);

        return redirect(route('prepaid.index'));
    }

    public function delete(){

    }
}
