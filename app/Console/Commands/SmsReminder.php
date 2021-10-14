<?php

namespace App\Console\Commands;

use AfricasTalking\SDK\AfricasTalking;
use App\Customer;
use App\Repositories\SMSRepository;
use App\SmsTemplate;
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
        $this->threeDayRunner();//1
        $this->todayRunner();//2
        $this->yesterdayRunner();//3
    }

    public function testRunner(){
        //$name = "Brav";
        $TransAmount = 100.00;

        $templateItem = SmsTemplate::whereSms("acknowledgement")->first();
        $message = $templateItem->template;

        //$message = str_replace('{name}',$name,$message);
        $message = str_replace('{amount}',$TransAmount,$message);
        $resp = $this->messenger->send("0718784058",$message);
        $this->messenger->saveSmsResponse($resp,$message);
    }

    public function threeDayRunner(){//Reminder Status 1
        $currentDate = date('Y-m-d');
        $in3days = date("Y-m-d", strtotime($currentDate. ' + 3 days'));
        echo "Processing records expiring on: ".$in3days."\n";
        $items = Subscription::whereDate('valid_until',$in3days)->get();

        $templateItem = SmsTemplate::whereSms("three_days_to")->first();
        $message = $templateItem->template;

        foreach ($items as $item){
            $customer = Customer::find($item->customer_id);
            $last_subscription = $customer->subscriptions->last();

            if ($last_subscription->status !== "up"){
                $resp = $this->messenger->send($customer->phone,$message);
                $this->messenger->saveSmsResponse($resp,$message,$customer);
                $item->reminded_at = date('Y-m-d h:i:s');
                $item->remind_status = 1;
                $item->save();
            }

        }

    }

    public function todayRunner(){//Reminder Status 2
        echo "Processing records expiring today \n";
        $expiringToday = Subscription::whereDate('valid_until',date('Y-m-d'))->get();

        $templateItem = SmsTemplate::whereSms("on_expiry_date")->first();
        $message = $templateItem->template;

        foreach ($expiringToday as $subscription){
            $customer = Customer::find($subscription->customer_id);
            $last_subscription = $customer->subscriptions->last();

            if ($last_subscription->status !== "up"){
                $time =  date('h:i A', strtotime($subscription->valid_until));
                $message = str_replace('{time}',$time,$message);
                $resp = $this->messenger->send($customer->phone,$message);
                $this->messenger->saveSmsResponse($resp,$message,$customer);
                $subscription->reminded_at = date('Y-m-d h:i:s');
                $subscription->remind_status = 2;
                $subscription->save();
            }

        }

    }

    public function yesterdayRunner(){//Reminder Status 3
        $yesterday = date("Y-m-d", strtotime("yesterday"));
        echo "Processing records that expired yesterday: ".$yesterday."\n";
        $expiredYesterday = Subscription::whereDate('valid_until',$yesterday)->get();

        $templateItem = SmsTemplate::whereSms("expired_yesterday")->first();
        $message = $templateItem->template;

        foreach ($expiredYesterday as $subscription){
            $customer = Customer::find($subscription->customer_id);
            $last_subscription = $customer->subscriptions->last();

            if ($last_subscription->status !== "up"){
                $resp = $this->messenger->send($customer->phone,$message);
                $this->messenger->saveSmsResponse($resp,$message,$customer);
                $subscription->reminded_at = date('Y-m-d h:i:s');
                $subscription->remind_status = 3;
                $subscription->save();
            }

        }

    }
}
