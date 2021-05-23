<?php

namespace App\Console\Commands;

use App\Lib\RouterOSAPI;
use App\PlanUser;
use http\Client;
use Illuminate\Console\Command;
use PEAR2\Net\RouterOS\Query;
use PEAR2\Net\RouterOS\Request;
use PEAR2\Net\RouterOS\Util;

class Worker extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'process:reminders';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Process client reminders via SMS or any other means';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $subscriptions = PlanUser::all();
        $router_os_ip = config('routeros.server');
        $username = config('routeros.user');
        $password = config('routeros.password');

        $API = new RouterOSAPI();
        $API->debug = false;
        $API->connect($router_os_ip, $username,$password,8728);

        $API->write("/queue/simple/getall",false);
        $API->write('?name='.'Bravo G',true);
        $READ = $API->read(false);
        $ARRAY = $API->parse_response($READ);

        if(count($ARRAY)>0){ // Edit if user exists
//            $limit = '10M/10M';
//            $API->write("/queue/simple/set",false);
//            $API->write("=.id=".$ARRAY[0]['.id'],false);
//            $API->write('=max-limit='.$limit,true);   //   2M/2M   [TX/RX]
//            $API->write('=limit-at='.$limit,true);   //   2M/2M   [TX/RX]
//            $API->write('comment=Renewed',true);
//            $READ = $API->read(false);
//            $ARRAY = $API->parse_response($READ);

            $API->write('/queue/simple/disable', false); // remove, enable, disable
            $API->write('=.id='.$ARRAY[0]['.id']);
            $API->read(false);

            //echo "Error: El nombre no puede estar duplicado, el queue fue editado.";
            //echo '<img src="../images/icon_error.png" />';
        }else{
            //Add to queue
//            $API->write("/queue/simple/add",false);
//            $API->write('=target='.$target,false);   // IP
//            $API->write('=name='.$name,false);
//            $API->write('=max-limit='.$maxlimit,false);   //   2M/2M   [TX/RX]
//            $API->write('=comment='.$comment,true);         // comentario
//            $READ = $API->read(false);
//            $ARRAY = $API->parse_response($READ);
//            echo "El Usuario $name, ha sido creado con exito!.";
//            echo '<img src="../images/okicon.png" />';
        }

        $API->disconnect();

    }
}
