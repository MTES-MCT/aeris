<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\Incinerateur;
use App\Entity\Declaration\DeclarationIncinerateur;
use App\Entity\Declaration\DeclarationDioxine;

use Aeris\Component\Report\AppliableRules;
use Aeris\Component\Report\MonthlyReport;

class IncinerateurController extends AerisController
{
    public function historique($incinerateurId)
    {
        $incinerateur = $this->getDoctrine()
            ->getRepository(Incinerateur::class)
            ->find($incinerateurId);

        if (!$incinerateur) {
            throw $this->createNotFoundException(
                "Pas d'incinerateur pour l' id ".$incinerateurId
            );
        }
        if(!$this->get('app.security.helper')->canAccessIncinerateur($incinerateur)) {
            return $this->redirect($this->generateUrl("route_index"));
        }

        return $this->render("user/historique.html.twig", [
            'incinerateur' =>  $incinerateur
        ]);
    }

    public function crDioxine($declarationId)
    {
        return $this->generateCRIfAllowed(
            $declarationId,
            DeclarationDioxine::class,
            "user/compte-rendu-declaration-dioxine.html.twig"
        );
    }

    private function generateCRIfAllowed(
        $declarationId,
        $type,
        $template)
    {
        $declaration = $this->getDoctrine()
            ->getRepository($type)
            ->find($declarationId);

        if (!$declaration) {
            throw $this->createNotFoundException(
                "Pas de declaration pour l' id ".$declarationId
            );
        }
        if(!$this->get('app.security.helper')->canAccessIncinerateur($declaration->getIncinerateur())) {
            return $this->redirect($this->generateUrl("route_index"));
        }

        return $this->render($template, [
            'declaration' => $declaration
        ]);
    }
} 