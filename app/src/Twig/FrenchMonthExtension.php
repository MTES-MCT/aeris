<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class FrenchMonthExtension extends AbstractExtension
{
    public function getFilters()
    {
        return array(
            new TwigFilter('monthfr', array($this, 'monthfr')),
        );
    }

    public function monthfr($date) {
        dump($date, get_class($date));
        $days = ["Dimanche", "Lundi", "Mardi", "Mercredi", "Jeudi", "Vendredi","Samedi"];
        // $months = ["Janvier", "Février", "Mars", "Avril", "Mai", "Juin", "Juillet", "Août", "Septembre", "Octobre", "Novembre", "Décembre"];
        $months = ["Jan.", "Fév.", "Mars", "Avr.", "Mai", "Juin", "Jui.", "Août", "Sep.", "Oct.", "Nov.", "Déc."];

        $datefr = '';
        if($date != null ){
            $datefr = $months[$date->format('n')]." ".$date->format('Y');
        }
        return $datefr;
    }
}


