<?php

namespace App\Listeners;

use App\Customer;
use App\Lib\MikrotikAPIClass;
use App\Lib\TransactionRepository;
use App\Subscription;
use App\Transaction;
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
            '1.00' => array(
                'name'=>"3mbps",
                'max-limit'=>"3M/3M",
                'limit-at'=>"3M/3M"
            ),
            '1500.00' => array(
                'name'=>"3mbps",
                'max-limit'=>"3M/3M",
                'limit-at'=>"3M/3M"
            ),
            '2500.00' => array(
                'name'=>"5mbps",
                'max-limit'=>"5M/5M",
                'limit-at'=>"5M/5M"
            ),
            '5000' => array(
                "name"=>"10mbps",
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

        //$service = $customer->active_plan();
        //$plan = $service->plan;
        $Trx = new TransactionRepository($transaction,$customer);
        $Trx = $Trx->store();

        $rate = $this->rates[$transaction->TransAmount];
        $data = array (
            "name" => $customer->name,
            "target" => $customer->default_target_ip,//"192.139.137.".$customer->id,
            "max-limit" => $rate['max-limit'],
            "limit-at" => $rate['limit-at'],
            "comment" =>  "Mpesa automatic plan update"
        );

        $this->MIKROTIK->queue($data);

        Subscription::updateOrCreate(['transaction_id'=>$Trx->id],[
            "customer_id"=>$customer->id,
            "plan"=>$rate['name'],
            'valid_from'=>date('Y-m-d h:i:s'),
            'valid_until'=>date('Y-m-d h:i:s', strtotime("+30 days"))
        ]);
        Log::info(json_encode($data));
    }
}
