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
        $richBody = $this->templating->render('mails/new-declaration/rich.html.twig', [
            'declaration' => $declaration
        ]);

        $inspecteur = $declaration
                        ->getIncinerateur()
                        ->getInspecteur();
        $recipients = [
            [ 'Email' => "clement.camin@beta.gouv.fr" ],
        ];
        if($inspecteur) {
            $recipients[] = [ 'Email' => $inspecteur->getEmail() ];
        }

        $body = [
            'FromEmail' => "clement.camin@beta.gouv.fr",
            'FromName' => "Aeris",
            'Subject' => "Aeris - Nouvelle déclaration de rejets dans l'air",
            'Text-part' => $rawBody,
            'Html-part' => $richBody,
            'Recipients' => $recipients
        ];

        return $body;
    }
}