<?php

namespace App\Console\Commands;

use App\Lib\MikrotikAPIClass;
use Illuminate\Console\Command;

class MikrotikAPI extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mikrotik:sandbox';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test various mikrotik logic';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $API = new MikrotikAPIClass();
        $API->addToFirewall(null);
    }
}
