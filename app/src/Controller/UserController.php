<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    public function dashboard()
    {
        return $this->render("inside/dashboard.html.twig");
    }

    public function declaration()
    {
        return $this->render("inside/declaration.html.twig");
    }

    public function cr()
    {
        $period = new \DatePeriod(
             new \DateTime('2018-03-01'),
             new \DateInterval('P1D'),
             new \DateTime('2018-03-31')
        );

        $dates = [];
        foreach ($period as $key => $value) {
            $dates[] = $value->format('Y-m-d');       
        }
        return $this->render("inside/cr.html.twig", ['dateList' => $dates]);
    }
} 