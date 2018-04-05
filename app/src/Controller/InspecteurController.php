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
    public function dashboard_inspecteur(){
        return $this->render("inspecteur/dashboard.html.twig");
    }

    public function liste_incinerateurs()
    {
        $incinerateurs = $this->getDoctrine()
            ->getRepository(Incinerateur::class)
            ->findAll();

        return $this->render("user/liste-incinerateurs.html.twig", [
            'incinerateurs' =>  $incinerateurs
        ]);
    }
} 