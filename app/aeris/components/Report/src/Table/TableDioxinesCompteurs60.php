<?php

namespace Aeris\Component\Report\Table;

use Aeris\Component\Report\DateUtils;

class TableDioxinesCompteurs60 {

    const MEASURE_COMPTEUR_60H = 'compt_art10_mensuel';

    public $compteur60DernierMois;
    public $dioxinesDernierMois;
    
    public $compteur60Annuel;
    public $dioxinesAnnuel;

    public function __construct($incinerateur, $ligneId) {
        $this->dioxinesDernierMois = 0;
        $this->dioxinesAnnuel = 0;
        $this->compteur60DernierMois = 0;
        $this->compteur60Annuel = 0;

    }
}