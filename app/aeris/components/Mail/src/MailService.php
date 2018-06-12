<?php

namespace Aeris\Component\Mail;

use \Mailjet\Resources;

class MailService {
    /** @var \Mailjet\Client */
    private $client;

    public function __construct(
        \Mailjet\Client $client
    ) {
        $this->client = $client;
    }

    public function send($body) {
        var_dump($body);
        // $response = $this->client->post(Resources::$Email, ['body' => $body]);
        // return $response;
    }
}