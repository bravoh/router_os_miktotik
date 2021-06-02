<?php


namespace App\Lib;


use App\Customer;
use App\Subscription;
use App\Transaction;
use Ramsey\Uuid\Uuid;
use Samerior\MobileMoney\Mpesa\Database\Entities\MpesaC2bCallback;

class TransactionRepository
{
    /**
     * @var MpesaC2bCallback
     */
    public $callback;
    public $customer;

    /**
     * TransactionRepository constructor.
     * @param MpesaC2bCallback $callback
     */
    public function __construct(MpesaC2bCallback $callback,Customer $customer)
    {
        $this->callback = $callback;
        $this->customer = $customer;
    }

    public function store(){
        $trx = Transaction::updateOrCreate(['trx_code'=>$this->callback->BillRefNumber],[
            "amount"=>$this->callback->TransAmount,
            "mode"=>"mpesa",
            "ref"=>date("ymdhis"),
            "trx_code"=>$this->callback->TransID,
            "customer_id"=>$this->customer->id,
            "customer_name"=>$this->customer->name,
            "uuid"=>Uuid::fromString(date("ymdhis")),
            "status"=>'paid',
            "date"=>date("Y-m-d h:i:s")
        ]);

        return $trx;
    }
}
