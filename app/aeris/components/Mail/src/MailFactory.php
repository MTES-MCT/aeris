<?php

namespace Aeris\Component\Mail;

class MailFactory {
    private $templating;
    private $declarationRepository;

    public function __construct($templating, $declarationRepository) {
        $this->templating = $templating;
        $this->declarationRepository = $declarationRepository;
    }

    public function createNewDeclarationInspecteurMessage($declarationId) {
        $declaration = $this->declarationRepository
            ->find($declarationId);

        $rawBody = $this->templating->render('mails/new-declaration/raw.txt.twig', [
            'declaration' => $declaration
        ]);

        $body = [
            'FromEmail' => "clement.camin@beta.gouv.fr",
            'FromName' => "Aeris",
            'Subject' => "Aeris - Nouvelle déclaration de rejets dans l'air",
            'Text-part' => $rawBody,
            'Html-part' => "<h3>Dear passenger, welcome to Mailjet!</h3><br/>May the delivery force be with you!",
            'Recipients' => [
                [
                    'Email' => "keirua+mj@gmail.com"
                ]
            ]
        ];

        return $body;
    }
}