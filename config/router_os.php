<?php
return [

    /**
     * Mikrotik Configuration
     */

    'server'=>env('ROUTER_OS_SERVER'),
    'user'=>env('ROUTER_OS_USER'),
    'password'=>env('ROUTER_OS_PASSWORD'),
    'port'=>env('ROUTER_OS_PORT',8728)
];
