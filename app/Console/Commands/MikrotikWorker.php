<?php

namespace App\Console\Commands;

use App\Lib\MikrotikAPIClass;
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
        foreach ($items as $item){
            try {
                $RouterClass->removeQueued(array(
                    'name'=>$item->customer->name,
                    'target_ip'=>$item->customer->target_ip
                ));
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
            ->last();

        if (count($Trx)){
            $rates = config('router_os.rates');

            $rate = $rates[$Trx->amount];

            $data = array (
                "name" => $customer->name,
                "target" => $customer->default_target_ip,//"192.139.137.".$customer->id,
                "max-limit" => $rate['max-limit'],
                "limit-at" => $rate['limit-at'],
                "comment" =>  "Mpesa automatic plan update"
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
}