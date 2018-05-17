<?php

namespace Aeris\Component\ReportParser\Parser\Dreal;

use Aeris\Component\ReportParser\FileParser;
use Aeris\Component\ReportParser\DataPoint;

class CompteursParser extends FileParser {
    const XSTART = 4;
    const YSTART = 3;

    private $rows = [
        'compt_art10_mensuel',
        'nb_dep_4h_mensuel',
        'nb_dep_c_moy_24h_mensuel',
        'nb_dep_f_24h_mensuel',
        'nb_moy_24h_invalides_mensuel'
    ];

    private $cols = [
        'Poussières',
        'CO',
        'COT',
        'HCl',
        'HF',
        'SO2',
        'NOX',
        'NH3'
    ];

    public function parseFile($filename) {
        $spreadsheet = $this->loadSpreadsheet($filename);
        for($col = 0; $col < count($this->cols); $col += 1) {
            for($row = 0; $row < count($this->rows); $row += 1) {
                $cellValue = $spreadsheet->getActiveSheet()->getCellByColumnAndRow(self::XSTART + $col, self::YSTART + $row)->getValue();

                echo $this->rows[$row]." ".$this->cols[$col]." => ".$cellValue."\n";
            }
        }
    }
}