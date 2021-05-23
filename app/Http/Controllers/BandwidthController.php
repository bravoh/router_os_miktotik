<?php

namespace App\Http\Controllers;

use App\BandWidth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class BandwidthController extends Controller
{
    public function index(){
        $items = BandWidth::all();
        return view('bandwidth.index',compact('items'));
    }

    public function create(){
        if (\request()->isMethod('POST'))
            return $this->save();

        return view('bandwidth.create');
    }

    public function save(){
        BandWidth::updateOrCreate(['id'=>\request()->id], Input::except('_token'));
        return redirect(route('bandwidth.index'));
    }
}
