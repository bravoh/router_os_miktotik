<?php

namespace App\Console\Commands;

use App\Customer;
use App\Repositories\SMSRepository;
use App\Sms;
use App\Subscription;
use Carbon\Carbon;
use Illuminate\Console\Command;

class ScheduledSmsRunner extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'scheduledsms:send';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check and send scheduled messages';

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
        $scheduled = Sms::where('tobe_sent_at', '>=', Carbon::now()->subMinutes(45)->toDateTimeString())
            ->whereNull("sent_at")
            ->whereNull("status")
            ->get();

        $SMSRepository = new SMSRepository();

        foreach ($scheduled as $item){
            $item->status = "Processing";
            $item->save();
            try {
                //Get recipients
                $recipients = $item->recipients;

                foreach ($recipients as $recipient){
                    //Send SMS
                    $resp = $SMSRepository->send($recipient, $item->message);
                    $customer = Customer::wherePhone($recipient)->first();
                    $SMSRepository->saveSmsResponse($resp, $item->message, $customer);
                }

                $item->sent_at = date('Y-m-d h:i:s');
                $item->status = "Success";
                $item->save();
            }catch (\Exception $exception){
                $item->status = "failed";
                $item->save();
            }
        }

    }
}
