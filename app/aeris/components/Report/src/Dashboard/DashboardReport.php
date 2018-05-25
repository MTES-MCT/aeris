<?php

namespace Aeris\Component\Report\Dashboard;

use Aeris\Component\Report\Graph\GraphQuantitesIncinerees;

class DashboardReport {
    public $graphQtitesIncinerees;

    public $cumulDebutAnnee;

    public function __construct($incinerateur) {
        $this->extraireQuantitesIncinerees($incinerateur);
    }

    private function extraireQuantitesIncinerees($incinerateur) {
        $this->graphQtitesIncinerees = new GraphQuantitesIncinerees($incinerateur);
    }
}