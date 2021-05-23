<?php


namespace App\Repositories;

use PEAR2\Net\RouterOS;
use App\Lib\RouterOSAPI;

class RouterOSRepository implements RouterOSInterface
{
    public $API;

    /**
     * Create a new RouterOS instance
     *
     * @return void
     */
    public function __construct()
    {
        $this->API = new RouterOSAPI();
        $this->API->debug = false;
        $this->API->connect(
            config('router_os.server'),
            config('router_os.user'),
            config('router_os.password'),
            config('router_os.port')
        );
    }

    public function queue($data) {
        $ARRAY = $this->searchQueueBy($data['name']);
        if (count($ARRAY)>0 )
            return $this->updateInQueue($data,$ARRAY);

        $this->addToQueue($data);
    }

    public function searchQueueBy($value, $key = 'name'){
        $this->API->write("/queue/simple/getall",false);
        $this->API->write('?'.$key.'='.$value,true);
        $READ = $this->API->read(false);
        return $this->API->parse_response($READ);
    }

    public function addToQueue($data){
        $this->API->write("/queue/simple/add",false);
        $this->API->write('=target='.$data['target'],false);   // IP
        $this->API->write('=name='.$data['name'],false);
        $this->API->write('=max-limit='.$data['max-limit'],false);//10M/10M   [TX/RX]
        $this->API->write('=limit-at='.$data['limit-at'],false); //10M/10M   [TX/RX]
        $this->API->write('=comment='.$data['comment'],true);// Comentario
        $READ = $this->API->read(false);
        $resp = $this->API->parse_response($READ);
        return json_encode($resp);
    }

    public function updateInQueue($data,$ARRAY){
        $this->API->write("/queue/simple/set",false);
        $this->API->write("=.id=".$ARRAY[0]['.id'],false);
        $this->API->write('=max-limit='.$data['max-limit'],true);   //   10M/10M   [TX/RX]
        $this->API->write('=limit-at='.$data['limit-at'],true);   //   10M/10M   [TX/RX]
        $this->API->write('comment='.$data['comment'],true);
        $READ = $this->API->read(false);
        return $this->API->parse_response($READ);
    }

    public function enableQueued($data){
        $ARRAY = $this->searchQueueBy($data['name']);
        $this->API->write('/queue/simple/enable', false); // remove, enable, disable
        $this->API->write('=.id='.$ARRAY[0]['.id']);
        $this->API->read(false);
    }

    public function disableQueued($data){
        $ARRAY = $this->searchQueueBy($data['name']);
        $this->API->write('/queue/simple/disable', false); // remove, enable, disable
        $this->API->write('=.id='.$ARRAY[0]['.id']);
        $this->API->read(false);
    }

    public function removeQueued($data){
        $ARRAY = $this->searchQueueBy($data['name']);
        $this->API->write('/queue/simple/remove', false); // remove, enable, disable
        $this->API->write('=.id='.$ARRAY[0]['.id']);
        $this->API->read(false);
    }

    public function close(){
        $this->API->disconnect();
    }
}
