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
            "Hello, your payment of Kshs. {amount} to CELNET INTERNET SOLUTIONS has been received. Thank you choosing our services.",
        'three_days_to'=>
            "Hi, your CELNET INTERNET SOLUTIONS subscription will expire in 3 days. To renew, Lipa na M-Pesa PayBill 4048411, Account No your phone number",
        'on_expiry_date'=>
            "Hello, your CELNET INTERNET SOLUTIONS subscription will expire today at {time}. To renew, Lipa na M-Pesa PayBill 4048411, Account No your phone number",
        'expired_yesterday'=>
            "Hi, your CELNET INTERNET SOLUTIONS subscription expired yesterday. To renew, Lipa na M-Pesa PayBill 4048411, Account No your phone number",
    ]
];
