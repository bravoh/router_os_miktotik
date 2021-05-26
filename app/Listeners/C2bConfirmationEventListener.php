<?php

namespace App\Listeners;

use App\Customer;
use App\Lib\MikrotikAPIClass;
use App\Repositories\RouterOSRepository;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;

class C2bConfirmationEventListener
{

    protected $MIKROTIK = null;
    private $rates;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        $this->MIKROTIK = new MikrotikAPIClass();

        $this->rates = array(
            1 => array(
                'name'=>"3mbps",
                'max-limit'=>"3M/3M",
                'limit-at'=>"3M/3M"
            ),
            1500 => array(
                'name'=>"3mbps",
                'max-limit'=>"3M/3M",
                'limit-at'=>"3M/3M"
            ),
            2500 => array(
                'name'=>"5mbps",
                'max-limit'=>"5M/5M",
                'limit-at'=>"5M/5M"
            ),
            5000 => array(
                "name"=>"10mbs",
                'max-limit'=>"10M/10M",
                'limit-at'=>"10M/10M"
            )
        );
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event){
        $transaction = $event->transaction;

        $customer = Customer::where('customer_no',$transaction->BillRefNumber)
            ->orWhere('phone',$transaction->BillRefNumber)
            ->first();

        $service = $customer->active_plan();
        $plan = $service->plan;
        $amount = $transaction->TransAmount;

        $rate = $this->rates[$amount];
        $data = array (
            "name" => $customer->name,
            "target" => "192.168.306.".$customer->id,
            "max-limit" => $rate['max-limit'],
            "limit-at" => $rate['limit-at'],
            "comment" => ucwords($customer->name)." Acc No ".$customer->customer_no." automatic plan update"
        );

        Log::alert('New Callback Received '.json_encode($transaction));
        Log::info(json_encode($data));
        $this->MIKROTIK->queue($data);
    }
}
