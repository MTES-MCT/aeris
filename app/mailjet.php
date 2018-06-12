<?php

require 'vendor/autoload.php';

use \Mailjet\Resources;
$publicAPIKey = '8159c7540028afab80cbf92b1d10c6b2';
$privateAPIKey = 'd121a25a325a9816f47acde9f5bc71a5';

$mj = new \Mailjet\Client($publicAPIKey, $privateAPIKey);
$body = [
    'FromEmail' => "clement@keiruaprod.fr",
    'FromName' => "Mailjet Pilot",
    'Subject' => "From docker, outside aeris!",
    'Text-part' => "Dear passenger, welcome to Mailjet! May the delivery force be with you!",
    'Html-part' => "<h3>Dear passenger, welcome to Mailjet!</h3><br/>May the delivery force be with you!",
    'Recipients' => [
        [
            'Email' => "keirua+mj@gmail.com"
        ]
    ]
];

$response = $mj->post(Resources::$Email, ['body' => $body]);
$response->success() && var_dump($response->getData());
