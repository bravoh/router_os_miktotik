<?php

namespace App\Http\Controllers;

use App\Plan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class PlanController extends Controller
{
    public function index(){
        $items = Plan::all();
        return view('plans.index',compact('items'));
    }

    public function hotspotCreate(){
        if (\request()->isMethod('POST'))
            return $this->save();

        return view('plans.hotspot.create');
    }

    public function pppoeCreate(){
        if (\request()->isMethod('POST'))
            return $this->save();

        return view('plans.pppoe.create');
    }

    public function delete(){

    }

    public function save(){
        Plan::updateOrCreate(['id'=>\request()->id], Input::except('_token'));
        return redirect(route('plans.index'));
    }
}
