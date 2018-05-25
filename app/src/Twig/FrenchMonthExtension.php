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
        $days = ["Dimanche", "Lundi", "Mardi", "Mercredi", "Jeudi", "Vendredi","Samedi"];
        $months = ["Jan.", "Fév.", "Mars", "Avr.", "Mai", "Juin", "Jui.", "Août", "Sep.", "Oct.", "Nov.", "Déc."];

        $datefr = '';
        if($date != null ){
            $datefr = $months[($date->format('n')-1)%12]."&nbsp;".$date->format('Y');
        }
        return $datefr;
    }
}


