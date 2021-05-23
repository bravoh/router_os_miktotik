<?php

namespace App\Repositories;

interface RouterOSInterface{
    public function queue($data);
    public function addToQueue($data);
    public function updateInQueue($data,$queue_item);
}
