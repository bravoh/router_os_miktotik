<?php

namespace App\Http\Controllers;

use App\Lib\MikrotikAPIClass;

class MirotikController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function systemStatus(){
        $routerOS = new MikrotikAPIClass();

        $data = array(
            'resource'=>$routerOS->systemResource(),
            'health'=>$routerOS->systemHealth()
        );

        return view('widgets.mikrotik.dimmer',compact('data'));
    }
}
