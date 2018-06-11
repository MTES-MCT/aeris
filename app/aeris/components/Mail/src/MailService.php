<?php

namespace Aeris\Component\Mail;

use \Mailjet\Resources;

class MailService {
    /** @var \Mailjet\Client */
    private $client;

    public function __construct(\Mailjet\Client $client) {
        $this->client = $client;
    }

    public function send() {
        $body = [
            'FromEmail' => "clement@keiruaprod.fr",
            'FromName' => "Mailjet Pilot",
            'Subject' => "Your email flight plan!",
            'Text-part' => "Dear passenger, welcome to Mailjet! May the delivery force be with you!",
            'Html-part' => "<h3>Dear passenger, welcome to Mailjet!</h3><br/>May the delivery force be with you!",
            'Recipients' => [
                [
                    'Email' => "keirua+mj@gmail.com"
                ]
            ]
        ];

        $response = $mj->post(Resources::$Email, ['body' => $body]);
        return $response;
    }
}