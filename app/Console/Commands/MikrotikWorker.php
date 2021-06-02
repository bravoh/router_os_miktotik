<?php

namespace App\Console\Commands;

use App\Lib\MikrotikAPIClass;
use App\Subscription;
use Illuminate\Console\Command;

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
        $items = Subscription::whereDate('valid_until', '<=', $currentDate)->get();
        foreach ($items as $item){
            $RouterClass = new MikrotikAPIClass();
            $RouterClass->removeQueued(array(
                'name'=>$item->customer->name,
                'target_ip'=>$item->customer->target_ip
            ));
            $item->putDown();
        }
    }
}
