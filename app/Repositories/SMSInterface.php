<?php
namespace App\Repositories;

interface SMSInterface{
    public function send($to,$message);
    public function balance();
    public function saveSmsResponse($resp, $message, $customer = null);
}
