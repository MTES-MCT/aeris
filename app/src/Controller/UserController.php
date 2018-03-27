<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    public function dashboard()
    {
        return $this->render("user/dashboard.html.twig");
    }

    public function declaration()
    {
        return $this->render("user/declaration.html.twig");
    }

    public function historique()
    {
        return $this->render("user/historique.html.twig");
    }

    public function cr()
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

        return $this->render("user/compte-rendu.html.twig", [
            'dateList' => $dates,
            'fluxCriterions' => $fluxCriterions,
            'counterList' => $counterList,
            'concentrationList' => $concentrationList,
        ]);
    }
} 