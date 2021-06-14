<?php
return [

    /**
     * Mikrotik Configuration
     */

    'server'=>env('ROUTER_OS_SERVER'),
    'user'=>env('ROUTER_OS_USER'),
    'password'=>env('ROUTER_OS_PASSWORD'),
    'port'=>env('ROUTER_OS_PORT',8728),
    'rates'=>array(
        '1.00' => array(
            'name'=>"3mbps",
            'max-limit'=>"3M/3M",
            'limit-at'=>"3M/3M",
            'type'=>'test'
        ),
        '2.00' => array(
            'name'=>"5mbps",
            'max-limit'=>"5M/5M",
            'limit-at'=>"5M/5M",
            'type'=>'test'
        ),
        '3.00' => array(
            'name'=>"10mbps",
            'max-limit'=>"10M/10M",
            'limit-at'=>"10M/10M",
            'type'=>'test'
        ),
        '1500.00' => array(
            'name'=>"3mbps",
            'max-limit'=>"3M/3M",
            'limit-at'=>"3M/3M",
            'type'=>'live'
        ),
        '2500.00' => array(
            'name'=>"5mbps",
            'max-limit'=>"5M/5M",
            'limit-at'=>"5M/5M",
            'type'=>'live'
        ),
        '5000' => array(
            "name"=>"10mbps",
            'max-limit'=>"10M/10M",
            'limit-at'=>"10M/10M",
            'type'=>'live'
        )
    )
];
