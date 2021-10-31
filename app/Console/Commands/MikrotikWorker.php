<?php

namespace App\Console\Commands;

use App\Lib\MikrotikAPIClass;
use App\PricingRate;
use App\Subscription;
use App\Transaction;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Ramsey\Uuid\Uuid;

class MikrotikWorker extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'down:expired';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Down expired connections';

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
        $currentDate = date('Y-m-d');

        $items = Subscription::whereDate('valid_until', '<=', $currentDate)
            ->whereStatus('up')
            ->get();

        $RouterClass = new MikrotikAPIClass();
        //var_dump($RouterClass);
        foreach ($items as $item){
            try {
                //$RouterClass->removeQueued(array(
                    //'name'=>$item->customer->first_name,
                    //'target_ip'=>$item->customer->target_ip
                //));
                $this->zeroQueue($item->customer,$RouterClass);
                $item->putDown();
                $this->processPendingVoucher($item->customer,$RouterClass);
            }catch (\Exception $exception){

            }
        }
    }

    /**
     * @param $customer
     * @param $MIKROTIK
     * @throws \Exception
     */
    public function processPendingVoucher($customer,$MIKROTIK){
        $Trx = Transaction::where('customer_id',$customer->id)
            ->whereStatus('voucher')
            ->orderBy('id','desc')
            ->first();

        if (!empty($Trx)){

            $rate = PricingRate::whereName($Trx->amount)->first();

            $data = array (
                "name" => $customer->first_name,
                "target" => $customer->default_target_ip,
                "max-limit" => $rate->maxLimit,
                "limit-at" => $rate->limitAt,
                "comment" =>  "KES ".$Trx->amount." voucher automatic processed"
            );

            $MIKROTIK->queue($data);

            $uuid = Uuid::uuid4();

            Subscription::updateOrCreate(['transaction_id'=>$Trx->id],[
                "customer_id"=>$customer->id,
                "plan"=>$rate['name'],
                'valid_from'=>date('Y-m-d h:i:s'),
                'valid_until'=>date('Y-m-d h:i:s', strtotime("+30 days")),
                "uuid"=>$uuid->toString()
            ]);

            $Trx->status = "completed";
            $Trx->voucher_processed_on = date('Y-m-d h:i:s');
            $Trx->save();
            Log::info(json_encode($data));
        }
    }

    public function zeroQueue($customer,$MIKROTIK){

        $data = array (
            "name" => $customer->first_name,
            "target" => $customer->default_target_ip,
            "max-limit" => "0/0",
            "limit-at" => "0/0",
            "comment" =>  "Downed on: ".date('Y-m-d h:i:s')
        );

        Log::alert('Downing Data: '.json_encode($data));

        $MIKROTIK->queue($data);
    }
}
