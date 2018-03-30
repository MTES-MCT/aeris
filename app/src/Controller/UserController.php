<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\Incinerateur;
use App\Entity\Declaration\DeclarationIncinerateur;

class UserController extends Controller
{
    public function liste_incinerateurs()
    {
        $incinerateurs = $this->getDoctrine()
            ->getRepository(Incinerateur::class)
            ->findAll();

        return $this->render("user/liste-incinerateurs.html.twig", [
            'incinerateurs' =>  $incinerateurs
        ]);
    }

    public function dashboard()
    {
        return $this->render("user/dashboard.html.twig");
    }

    public function declaration()
    {
        return $this->render("user/declaration.html.twig");
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

        return $this->render("user/compte-rendu-declaration.html.twig", [
            'declaration' => $declaration
        ]);
    }

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
    }
} 