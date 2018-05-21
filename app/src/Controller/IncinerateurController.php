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
    private function canAccessIncinerateur($incinerateur){
        $authChecker = $this->get('security.authorization_checker'); 
        if ($authChecker->isGranted('ROLE_INSPECTEUR')) {
            return true;
        }
        if($authChecker->isGranted('ROLE_PROPRIETAIRE')) {
            $mainIncinerateur = $this->getMainIncinerateur();
            return $mainIncinerateur->getId() == $incinerateur->getId();
        }
        return false;
    }

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
        if(!$this->canAccessIncinerateur($incinerateur)) {
            return $this->redirect($this->generateUrl("route_index"));
        }

        return $this->render("user/historique.html.twig", [
            'incinerateur' =>  $incinerateur
        ]);
    }

    public function cr($declarationId)
    {
        $declaration = $this->getDoctrine()
            ->getRepository(DeclarationIncinerateur::class)
            ->find($declarationId);

        if (!$declaration) {
            throw $this->createNotFoundException(
                "Pas de declaration pour l' id ".$declarationId
            );
        }
        if(!$this->canAccessIncinerateur($declaration->getIncinerateur())) {
            return $this->redirect($this->generateUrl("route_index"));
        }


        $rules = new AppliableRules();

        $reports = [];
        foreach($declaration->getDeclarationsFonctionnementLigne() as $declarationLigne) {
            $report = new MonthlyReport($declaration->getDeclarationMonth(), $rules);
            $report->fillWithMeasures($declarationLigne->getMesures());
        
            $reports[$declarationLigne->getLigne()->getNumero()] = $report;
        }

        return $this->render("user/compte-rendu-declaration.html.twig", [
            'declaration' => $declaration,
            'reports' => $reports,
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
        if(!$this->canAccessIncinerateur($declaration->getIncinerateur())) {
            return $this->redirect($this->generateUrl("route_index"));
        }

        return $this->render($template, [
            'declaration' => $declaration
        ]);
    }
} 