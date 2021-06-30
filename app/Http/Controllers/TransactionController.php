<?php

namespace App\Http\Controllers;

use App\Transaction;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class TransactionController extends Controller
{
    public function index(){
        //$transactions = Transaction::all();
        $transactions = Transaction::orderBy('id','desc')->get();
        /*$test = DB::table('transactions')->distinct('customer_name')->count('customer_id');
        echo "<pre>";
        print_r($test);die();*/
        /*$test = DB::table('transactions')
                 ->select('customer_id', DB::raw('count(*) as total'))
                 ->groupBy('customer_id')
                 ->get();
                 echo "<pre>";
                 print_r($test);die();*/
        return view('transaction.index',compact('transactions'));
    }

}
