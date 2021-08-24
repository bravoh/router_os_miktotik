<?php

namespace App\Http\Controllers;

use App\Lib\MikrotikAPIClass;
use TCG\Voyager\Models\Setting;

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
        //if (file_exists(public_path("dashboard-stats"))){
            //$files = scandir(public_path("dashboard-stats"), SCANDIR_SORT_DESCENDING);
            //$data = json_decode($files[0]);
        //}else{
        $data = $this->cron();
        //}
        return view('widgets.mikrotik.dimmer',compact('data'));
    }

    public function cron(){
        $routerOS = new MikrotikAPIClass();

        $connections = $routerOS->connections();
        $active_connections = [];
        $online_today = [];

        foreach ($connections as $connection){
            $ip = explode(":",$connection['src-address']);
            if ($connection['timeout'] == "0s")
                $active_connections[$ip[0]] = $connection;

            $online_today[$ip[0]] = $connection;
        }
        $customers = $routerOS->customers();
        $downed = [];
        $active = [];

        foreach ($customers as $customer){
            if ($customer['limit-at'] == "0/0"){
                $downed[] = $customer;
            }else{
                $active[] = $customer;
            }
        }

        $data = array(
            'resource'=>$routerOS->systemResource(),
            'health'=>$routerOS->systemHealth(),
            'connections'=>array(
                'all'=>$routerOS->connections(),
                'online'=>$active_connections,
                'online_today'=>$online_today
            ),
            'customers'=>array(
                'all'=>$customers,
                'active'=>$active,
                'downed'=>$downed
            )
        );

        //file_put_contents(public_path("dashboard-stats/".now().".json"), json_encode($data));
        return $data;
    }
}
