<?php

namespace App\Http\Controllers;

use App\Customer;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
            'default_target_ip'=>\request()->default_target_ip,
        ]);
        if (!$edit)
            $this->generateCustomerNo($customer);

        return redirect(route('customers.index'));
    }

    public function generateCustomerNo($customer){
        $customer->customer_no = date('Y').sprintf("%03d",$customer->id);
        $customer->save();
    }
    public function edit($id = null){
        $customersInfo = DB::table('customers')->find($id);
        return view('customer.edit',compact('customersInfo'));
    }
    
    public function delete($id = null){
        DB::table('customers')->delete($id);
        return redirect(route('customers.index')); 
    }
}
