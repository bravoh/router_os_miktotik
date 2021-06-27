<?php
return [
    'africas_talking'=>[
        'username'=>env('AFRICAS_TALKING_USERNAME'),
        'apikey'=>env('AFRICAS_TALKING_APIKEY')
    ],
    'another_provider'=>[
        //their api credentials here
    ],
    'templates'=>[
        'acknowledgement'=>
            "Hello {name}, your payment of Kshs. {amount} has been received. Thank you choosing our services.",
        'three_days_to'=>
            "{name}, your internet subscription will expire in 3 days time. Lipa na M-Pesa PayBill 4048411, Account No your phone number",
        'on_expiry_date'=>
            "{name}, your internet subscription will expire today at {time}.Lipa na M-Pesa PayBill 4048411, Account No your phone number",
        'expired_yesterday'=>
            "{name}, your internet subscription expired yesterday. To renew, Lipa na M-Pesa PayBill 4048411, Account No your phone number",
    ]
];
