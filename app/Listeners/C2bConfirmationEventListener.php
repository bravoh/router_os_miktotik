<?php

namespace App\Listeners;

use App\Customer;
use App\Repositories\RouterOSRepository;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;

class C2bConfirmationEventListener
{

    protected $routerOsRepository = null;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(RouterOSRepository $routerOsRepository)
    {
        $this->routerOsRepository = $routerOsRepository;
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

        $data = array (
            "name" => $customer->name,
            "target" => $service->target_ip,
            "max-limit" => "5M/5M",
            "limit-at" => "5M/5M",
            "comment" => ucwords($customer->name)." automatic plan update"
        );

        //$this->routerOsRepository->enableQueued($data);
        $this->routerOsRepository->queue($data);
    }
}
