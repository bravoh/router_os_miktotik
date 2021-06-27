<?php

namespace App\Console\Commands;

use AfricasTalking\SDK\AfricasTalking;
use App\Repositories\SMSRepository;
use App\Subscription;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class SmsReminder extends Command
{
    /**
     * @var AfricasTalking
     */
    public $messenger;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sms:reminder';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send SMS reminders';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->messenger = new SMSRepository();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //$this->testRunner();
        $this->threeDayRunner();
        $this->todayRunner();
        $this->yesterdayRunner();
    }

    public function testRunner(){
        $name = "Brav";
        $TransAmount = 100.00;
        $message = config('sms.templates.acknowledgement');
        $message = str_replace('{name}',$name,$message);
        $message = str_replace('{amount}',$TransAmount,$message);

        $resp = $this->messenger->send("0718784058",$message);
        $this->messenger->saveSmsResponse($resp,$message);
    }

    public function threeDayRunner(){
        $currentDate = date('Y-m-d');
        $in3days = date("Y-m-d", strtotime($currentDate. ' + 3 days'));

        echo "Processing records expiring on: ".$in3days."\n";
        $expiringIn3Days = Subscription::whereDate('valid_until',$in3days)
            ->whereNull('reminded_at')
            ->get();
        $message = config('sms.templates.three_days_to');
        foreach ($expiringIn3Days as $subscription){
            //DB::transaction(function ()use($subscription,$message){
                $message = str_replace('{name}',$subscription->customer->name,$message);
                $resp = $this->messenger->send($subscription->customer->phone,$message);
                $this->messenger->saveSmsResponse($resp,$message);

                $subscription->reminded_at = date('Y-m-d h:i:s');
                $subscription->save();
            //});
        }
    }

    public function todayRunner(){
        echo "Processing records expiring today \n";
        $expiringToday = Subscription::whereDate('valid_until',Carbon::today())
            ->whereNull('reminded_at')
            ->get();
        $message = config('sms.templates.three_days_to');
        foreach ($expiringToday as $subscription){
            //DB::transaction(function ()use ($subscription,$message){
                $time =  date('h:i A', strtotime($subscription->valid_until));
                $message = str_replace('{name}',$subscription->customer->name,$message);
                $message = str_replace('{time}',$time,$message);
                $resp = $this->messenger->send($subscription->customer->phone,$message);
                $this->messenger->saveSmsResponse($resp,$message);

                $subscription->reminded_at = date('Y-m-d h:i:s');
                $subscription->save();
            //});
        }
    }

    public function yesterdayRunner(){
        $yesterday = date("Y-m-d", strtotime("yesterday"));
        echo "Processing records that expired yesterday: ".$yesterday."\n";
        $expiredYesterday = Subscription::whereDate('valid_until',$yesterday)
            ->whereNull('reminded_at')
            ->get();
        $message = config('sms.templates.expired_yesterday');

        foreach ($expiredYesterday as $subscription){
            //DB::transaction(function ()use ($subscription,$message){
                $message = str_replace('{name}',$subscription->customer->name,$message);
                $resp = $this->messenger->send($subscription->customer->phone,$message);
                $this->messenger->saveSmsResponse($resp,$message);

                $subscription->reminded_at = date('Y-m-d h:i:s');
                $subscription->save();
            //});
        }
    }
}
