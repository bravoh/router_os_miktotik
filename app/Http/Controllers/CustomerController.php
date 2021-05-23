<?php

namespace App\Http\Controllers;

use App\Customer;
use App\User;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index(){
        $items = Customer::all();
        return view('customer.index',compact('items'));
    }

    public function create(){
        if (\request()->isMethod('POST'))
            return $this->saveCustomer();

        return view('customer.create');
    }

    public function saveCustomer($edit = false){
        $customer = Customer::updateOrCreate(['id'=>\request()->id],[
            'name'=>\request()->name,
            'email'=>\request()->email,
            'phone'=>\request()->phone,
        ]);
        if (!$edit)
            $this->generateCustomerNo($customer);

        return redirect(route('customers.index'));
    }

    public function generateCustomerNo($customer){
        $customer->customer_no = date('Y').sprintf("%03d",$customer->id);
        $customer->save();
    }
}
