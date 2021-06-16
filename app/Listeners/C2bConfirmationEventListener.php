<?php

namespace App\Listeners;

use App\Customer;
use App\Lib\MikrotikAPIClass;
use App\Lib\TransactionRepository;
use App\Subscription;
use App\Transaction;
use Illuminate\Support\Facades\Log;
use Ramsey\Uuid\Uuid;

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
        $this->rates = config('router_os.rates');
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

        $Trx = new TransactionRepository(
            $transaction,
            $customer
        );

        $Trx = $Trx->store();

        if ($Trx->status !== "voucher"){
            $rate = $this->rates[
                $transaction->TransAmount
            ];

            $data = array (
                "name" => $customer->name,
                "target" => $customer->default_target_ip,//"192.139.137.".$customer->id,
                "max-limit" => $rate['max-limit'],
                "limit-at" => $rate['limit-at'],
                "comment" =>  @$transaction->MSISDN." M-Pesa automatic plan update"
            );

            $this->MIKROTIK->queue($data);

            $uuid = Uuid::uuid4();

            Subscription::updateOrCreate(['transaction_id'=>$Trx->id],[
                "customer_id"=>$customer->id,
                "plan"=>$rate['name'],
                'valid_from'=>date('Y-m-d h:i:s'),
                'valid_until'=>date('Y-m-d h:i:s', strtotime("+30 days")),
                "uuid"=>$uuid->toString()
            ]);
            Log::alert('New Callback Received '.json_encode($transaction));
            Log::info(json_encode($data));
        }

    }
}
