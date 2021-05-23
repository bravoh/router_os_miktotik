<?php


namespace App\Repositories;


use AfricasTalking\SDK\AfricasTalking;

class SMSRepository implements SMSInterface
{
    public $AT;

    /**
     * Create a new RouterOS instance
     *
     * @return void
     */
    public function __construct()
    {
        $username = 'YOUR_USERNAME'; // use 'sandbox' for development in the test environment
        $apiKey   = 'YOUR_API_KEY'; // use your sandbox app API key for development in the test environment

        $this->AT = new AfricasTalking(
            $username,
            $apiKey
        );
    }

    public function send($to,$message){
        // Get one of the services
        $sms      = $this->AT->sms();

        // Use the service
        $result   = $sms->send([
            'to'      => $to,
            'message' => $message
        ]);

        return json_encode($result);
    }

    public function balance(){
        // Get the application service
        $application = $this->AT->application();

        try {
            // Fetch the application data
            $data = $application->fetchApplicationData();

            return json_encode($data);
        } catch(Exception $e) {
            echo "Error: ".$e->getMessage();
        }
    }
}
