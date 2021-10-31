<?php

namespace App\Listeners;

use App\Customer;
use App\Lib\MikrotikAPIClass;
use App\Lib\TransactionRepository;
use App\PricingRate;
use App\Repositories\SMSRepository;
use App\SmsTemplate;
use App\Subscription;
use App\Transaction;
use Illuminate\Support\Facades\Log;
use Ramsey\Uuid\Uuid;

class C2bConfirmationEventListener
{

    protected $MIKROTIK = null;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        $this->MIKROTIK = new MikrotikAPIClass();
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

        Log::alert('Customer: '.json_encode($customer));

        try {
            //Thank you SMS
            $this->thankYouSms($customer,$transaction);
        }catch (\Exception $exception){

        }

        $Trx = new TransactionRepository(
            $transaction,
            $customer
        );

        $Trx = $Trx->store();

        if ($Trx->status !== "voucher"){

            $rate = PricingRate::whereName($transaction->TransAmount)->first();

            $data = array (
                "name" => $customer->first_name,
                "target" => $customer->default_target_ip,//"192.139.137.".$customer->id,
                "max-limit" => $rate->maxLimit,
                "limit-at" => $rate->limitAt,
                "comment" =>  @$transaction->MSISDN." M-Pesa automatic plan update"
            );

            $this->MIKROTIK->queue($data);
            $uuid = Uuid::uuid4();

            Subscription::updateOrCreate(['transaction_id'=>$Trx->id],[
                "customer_id"=>$customer->id,
                "plan"=>$rate->name,
                'valid_from'=>date('Y-m-d h:i:s'),
                'valid_until'=>date('Y-m-d h:i:s', strtotime("+30 days")),
                "uuid"=>$uuid->toString()
            ]);

            Log::alert('New Callback Received '.json_encode($transaction));
        }
    }

    public function thankYouSms($customer,$trx){
        $name = $customer->first_name;
        $name = explode(' ',$name)[0];
        $templateItem = SmsTemplate::whereSms("acknowledgement")->first();
        $message = $templateItem->template;
        $message = str_replace('{name}',$name,$message);
        $message = str_replace('{amount}',$trx->TransAmount,$message);

        Log::info($message);

        $MessageService = new SMSRepository();
        $resp = $MessageService->send($customer->phone,$message);
        $MessageService->saveSmsResponse($resp,$message);

        Log::info($resp);
    }
}
