<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PEAR2\Net\RouterOS;

//require_once '../../../lib/PEAR2/Autoload.php';

class RouterOSController extends Controller
{
    public $client;
    public $util;

    /**
     * Create a new RouterOS instance
     *
     * @return void
     */
    public function __construct()
    {
        $router_os_ip = "167.71.253.235";
        $username = "admin";
        $password = "password";

        try {
            $this->client = new RouterOS\Client($router_os_ip,$username,$password);
            $this->util = new RouterOS\Util($this->client);
        }catch (\Exception $exception){
            dd($exception);
        }
    }

    public function queue() {
        //Test Queue Data
        $ip= "41.139.137.1";  // IP Cliente
        $name=    "Bravo LLP";
        $maxlimit= "5M/5M";
        $comment= "Este es un ejemplo.";

        //When adding
        $this->util->setMenu('/queue simple');

        if (empty($this->existsInQueue($ip))){
            $this->addToQueue(array (
                "name" => $name,
                "target" => $ip,
                "max-limit" => $maxlimit,
                "limit-at" => $maxlimit
            ));
        }else{
            $this->updateQueue(array (
                "name" => $name,
                "target" => $ip,
                "max-limit" => $maxlimit,
                "limit-at" => $maxlimit
            ));
        }


    }

    public function addToQueue($data){
        $this->util->add($data);

        $this->util
            ->setMenu('/ip arp')
            ->add(array(
                "address" => $data['ip'],
                "interface" => 'ether1',
                //'mac-address' => '01:00:00:00:00:01',
                "comment" => 'Este es un ejemplo.'
            )
        );
    }

    public function updateQueue($data){

    }

    public function existsInQueue($ip){
        $this->util->setMenu('/queue simple');

        return  $this->util->find(
            function ($response) use ($ip){
                //Matches any item with a comment that starts with two digits
                return preg_match('/^'.$ip.'/im', $response->getProperty('target'));
            }
        );
    }
}
