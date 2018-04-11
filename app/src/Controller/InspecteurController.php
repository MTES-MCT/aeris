<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\Incinerateur;
use App\Entity\Declaration\DeclarationDechets;
use App\Entity\Declaration\DeclarationIncinerateur;
use App\Entity\Declaration\MesureDioxine;
use App\Form\DeclarationIncinerateurType;
use App\Form\DeclarationFonctionnementLigneType;
use App\Form\DeclarationDechetsType;
use App\Form\MesureDioxineType;
use App\Form\DeclarationFonctionnementLigne;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;

class InspecteurController extends AerisController
{
    private function isInspecteur(){
        $authChecker = $this->get('security.authorization_checker'); 
        return $authChecker->isGranted('ROLE_INSPECTEUR');
    }

    public function dashboard_inspecteur(){

        return $this->render("inspecteur/dashboard.html.twig");
    }

    public function dashboard_incinerateur($incinerateurId)
    {
        $incinerateur = $this->getDoctrine()
            ->getRepository(Incinerateur::class)
            ->find($incinerateurId);

        if (!$incinerateur) {
            throw $this->createNotFoundException(
                "Pas d'incinerateur pour l' id ".$incinerateurId
            );
        }
        if(!$this->isInspecteur()) {
            return $this->redirect($this->generateUrl("route_index"));
        }

        $dashboardData = $this->getIncinerateurDashboardData($incinerateur);

        return $this->render("inspecteur/dashboard-incinerateur.html.twig", array_merge([
            'incinerateur' =>  $incinerateur
        ], $dashboardData));
    }

    public function liste_incinerateurs()
    {
        if (!$this->isInspecteur()) {
            return $this->redirect($this->generateUrl("route_index"));
        }

        $incinerateurs = $this->getDoctrine()
            ->getRepository(Incinerateur::class)
            ->findAll();

        return $this->render("inspecteur/liste-incinerateurs.html.twig", [
            'incinerateurs' =>  $incinerateurs
        ]);
    }
} 