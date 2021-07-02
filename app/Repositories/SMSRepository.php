<?php


namespace App\Repositories;


use AfricasTalking\SDK\AfricasTalking;
use App\Sms;
use Illuminate\Support\Facades\Log;

class SMSRepository implements SMSInterface
{

    /**
     * @var AfricasTalking
     */
    public $AT;

    /**
     * Create a new RouterOS instance
     *
     * @return void
     */
    public function __construct()
    {
        $username = config('sms.africas_talking.username'); // use 'sandbox' for development in the test environment
        $apiKey   = config('sms.africas_talking.apikey'); // use your sandbox app API key for development in the test environment

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
        } catch(\Exception $e) {
            echo "Error: ".$e->getMessage();
        }
    }

    public function saveSmsResponse($resp, $message, $customer = null){
        $resp = json_decode($resp);
        $data = (object)$resp->data->SMSMessageData->Recipients[0];
        Sms::create([
            'messageId'=>$data->messageId,
            'customer_id'=>$customer->id,
            'recipient'=>$data->number,
            'message'=>$message,
            'messageParts'=>$data->messageParts,
            'cost'=>$data->cost,
            'status'=>$data->status,
            'statusCode'=>$data->statusCode
        ]);
    }
}
