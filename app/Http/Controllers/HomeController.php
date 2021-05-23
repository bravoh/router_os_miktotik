<?php

namespace App\Http\Controllers;

use App\Repositories\RouterOSRepository;
use Illuminate\Http\Request;

class HomeController extends Controller
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
            "name" => "Bravo G",
            "target" => "192.139.137.1",
            "max-limit" => "5M/5M",
            "limit-at" => "5M/5M",
            "comment" => "Este es un ejemplo."
        );

        //$this->routerOsRepository->queue($data);
    }
}
