<?php


namespace App\Lib;


use App\Customer;
use App\Transaction;
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
        Transaction::updateOrCreate([
            'trx_code'=>$this->callback->BillRefNumber],[
        ]);
    }
}
