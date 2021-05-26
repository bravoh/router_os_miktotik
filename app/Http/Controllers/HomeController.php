<?php

namespace App\Http\Controllers;

use App\Lib\MikrotikAPIClass;

class HomeController extends Controller
{

    protected $MIKROTIK = null;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->MIKROTIK = new MikrotikAPIClass();
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function sandBox(){
        $data = array (
            "name" => "Bravo G (Test User)",
            "target" => "192.139.137.1",
            "max-limit" => "5M/5M",
            "limit-at" => "5M/5M",
            "comment" => "This is a test for lipa na MPesa Automation"
        );

        $this->MIKROTIK->queue($data);
    }
}
