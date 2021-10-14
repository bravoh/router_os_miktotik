<?php

use Illuminate\Database\Seeder;
use App\SmsTemplate;

class SmsTemplateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $templates = config("sms.templates");
        foreach ($templates as $key => $template){
            SmsTemplate::updateOrCreate(["sms"=>$key],[
                "template"=>$template
            ]);
        }
    }
}
