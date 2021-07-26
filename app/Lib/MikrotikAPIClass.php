<?php


namespace App\Lib;

use Illuminate\Support\Facades\Log;
use RouterOS\Query;
use RouterOS\Config;
use RouterOS\Client;

class MikrotikAPIClass
{
    /**
     * @var Client
     */
    public $client;

    /**
     * Create a new connection instance
     *
     * @return void
     */
    public function __construct()
    {
        try {
            $config = new Config([
                'host' => config('router_os.server'),
                'user' => config('router_os.user'),
                'pass' => config('router_os.password'),
                'port' => intval(config('router_os.port')),
                'timeout' => 5,
                'attempts' => 1
            ]);

            $this->client = new Client($config);
        }catch (\Exception $exception){
            Log::error($exception);
        }
    }

    /**
     * @param $data
     * @return mixed
     * @throws \RouterOS\Exceptions\ClientException
     * @throws \RouterOS\Exceptions\ConfigException
     * @throws \RouterOS\Exceptions\QueryException
     */
    public function queue($data) {
        $ARRAY = $this->searchQueueBy($data['name']);
        if (count($ARRAY)>0 )
            return $this->updateInQueue($data,$ARRAY);
        $this->addToQueue($data);
    }

    /**
     * @param $value
     * @param string $key
     * @return mixed
     * @throws \RouterOS\Exceptions\ClientException
     * @throws \RouterOS\Exceptions\ConfigException
     * @throws \RouterOS\Exceptions\QueryException
     */
    public function searchQueueBy($value,$key='name'){
        $query = (new Query('/queue/simple/getall'))
            ->where($key, $value);
        return $this->client->query($query)->read();
    }

    /**
     * @param $data
     * @throws \RouterOS\Exceptions\ClientException
     * @throws \RouterOS\Exceptions\ConfigException
     * @throws \RouterOS\Exceptions\QueryException
     */
    public function addToQueue($data){
        $query = (new Query('/queue/simple/add'))
            ->equal('name', $data['name'])
            ->equal('target', $data['target'])
            ->equal('max-limit', $data['max-limit'])
            ->equal('limit-at', $data['limit-at'])
            ->equal('comment', $data['comment']);

        $this->client->query($query)->read();
    }

    /**
     * @param $data
     * @param $ARRAY
     * @return mixed
     * @throws \RouterOS\Exceptions\ClientException
     * @throws \RouterOS\Exceptions\ConfigException
     * @throws \RouterOS\Exceptions\QueryException
     */
    public function updateInQueue($data,$ARRAY){
        $query = (new Query('/queue/simple/set'))
            ->equal('.id', $ARRAY[0]['.id'])
            ->equal('name', $data['name'])
            ->equal('target', $data['target'])
            ->equal('max-limit', $data['max-limit'])
            ->equal('limit-at', $data['limit-at'])
            ->equal('comment', $data['comment']);

        return $this->client->query($query)->read();
    }

    /**
     * @param $data
     * @return mixed
     * @throws \RouterOS\Exceptions\ClientException
     * @throws \RouterOS\Exceptions\ConfigException
     * @throws \RouterOS\Exceptions\QueryException
     */
    public function enableQueued($data){
        $ARRAY = $this->searchQueueBy($data['name']);
        $query = (new Query('/queue/simple/enable'))->equal('.id', $ARRAY[0]['.id']);
        return $this->client->query($query)->read();
    }

    /**
     * @param $data
     * @return mixed
     * @throws \RouterOS\Exceptions\ClientException
     * @throws \RouterOS\Exceptions\ConfigException
     * @throws \RouterOS\Exceptions\QueryException
     */
    public function disableQueued($data){
        $ARRAY = $this->searchQueueBy($data['name']);
        $query = (new Query('/queue/simple/disable'))
            ->equal('.id', $ARRAY[0]['.id']);

        return $this->client->query($query)->read();
    }

    /**
     * @param $data
     * @return mixed
     * @throws \RouterOS\Exceptions\ClientException
     * @throws \RouterOS\Exceptions\ConfigException
     * @throws \RouterOS\Exceptions\QueryException
     */
    public function removeQueued($data){
        $ARRAY = $this->searchQueueBy($data['name']);

        if(count($ARRAY)){
            $query = (new Query('/queue/simple/remove'))->equal('.id', $ARRAY[0]['.id']);
            return $this->client->query($query)->read();
        }

        return false;
    }

    /**
     * @param $data
     * @throws \RouterOS\Exceptions\ClientException
     * @throws \RouterOS\Exceptions\ConfigException
     * @throws \RouterOS\Exceptions\QueryException
     */
    public function addToFirewall($data){
        //$ARRAY = $this->searchQueueBy($data['name']);
        $query = (new Query("/ip/firewall/address-list/add"))
            ->equal("list","test")
            ->equal("comment","test")
            ->equal("address","192.168.2.33");

        return $this->client->query($query)->read();
    }

    /**
     * @throws \RouterOS\Exceptions\ClientException
     * @throws \RouterOS\Exceptions\ConfigException
     * @throws \RouterOS\Exceptions\QueryException
     */
    public function readInFirewall(){
        $query = (new Query("/ip/firewall/address-list/getall"));
        dd($this->client->query($query)->read());
    }
}
