<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\Incinerateur;
use App\Entity\Declaration\DeclarationIncinerateur;
use App\Entity\Declaration\DeclarationDioxine;

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
        return $this->generateCRIfAllowed(
            $declarationId,
            DeclarationIncinerateur::class,
            "user/compte-rendu-declaration.html.twig"
        );
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

/*
    public function crSample()
    {
        $period = new \DatePeriod(
             new \DateTime('2018-03-01'),
             new \DateInterval('P1D'),
             new \DateTime('2018-04-01')
        );

        $dates = [];
        foreach ($period as $key => $value) {
            $dates[] = $value->format('d/m/Y');       
        }

        $fluxCriterions = [ 'Poussières', 'CO', 'COT', 'Hcl', 'HF', 'SO2', 'Nox', 'NH3'];
        $counterList = [ 'Poussières', 'CO', 'COT', 'HCl',  'HF', 'SO2', 'NOX', 'NH3', 'Total' ];
        $concentrationList = [ 'Poussières', 'COT', 'HCl',  'HF', 'SO2', 'NOX', 'NH3', 'Total' ];

        return $this->render("user/compte-rendu-sample.html.twig", [
            'dateList' => $dates,
            'fluxCriterions' => $fluxCriterions,
            'counterList' => $counterList,
            'concentrationList' => $concentrationList,
        ]);
    }*/
} 