<?php

use Illuminate\Database\Seeder;
use App\PricingRate;

class PricingRateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $rates = config("router_os.rates");

        foreach ($rates as $key => $rate){
            PricingRate::updateOrCreate(["name" => $key],[
                "maxLimit" => $rate['max-limit'],
                "limitAt" => $rate['limit-at'],
                "type" => $rate['type'],
            ]);
        }
    }
}
