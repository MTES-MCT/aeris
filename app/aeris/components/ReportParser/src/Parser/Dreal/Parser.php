<?php

namespace Aeris\Component\ReportParser\Parser\Dreal;

use Aeris\Component\ReportParser\FileParser;
use Aeris\Component\ReportParser\DataPoint;

class Parser extends FileParser {
    public function parseFile($filename) {
        $spreadsheet = $this->loadSpreadsheet($filename);

        $dates = $this->getDates($spreadsheet);
        $dataPoints = [];
        foreach ($this->fields as $currentField) {
            $fieldInfos = $this->parseColumn($spreadsheet, $currentField, $dates);
            $dataPoints = array_merge($dataPoints, $fieldInfos);
        }

        return $dataPoints;
    }

    protected function getDates($spreadsheet) {
        $dates = [];

        for ($i=0; $i < 31; $i++) { 
            $position = $this->initialVerticalOffset+$i;
            $cellValue = $spreadsheet->getActiveSheet()->getCellByColumnAndRow(1, $position)->getValue();
            if(empty($cellValue)) {
                break;
            }
            $dates[] = [$position, $this->dateFromExcelDate($cellValue)];
        }

        return $dates;
    }

    protected function getColumnIndex($spreadsheet, $columnName, $row = 1){
        $i = 1; 
        $matchingIndex = -1;
        do {
            $cellValue = $spreadsheet->getActiveSheet()->getCellByColumnAndRow($i, $row)->getValue();
            if (empty($cellValue)) {
                break;
            }
            elseif ($cellValue === $columnName) {
                $matchingIndex = $i;
                break;
            }
            $i += 1;
        }
        while(true);

        return $matchingIndex;
    }

    protected function parseColumn($spreadsheet, $columnName, $dates) {
        $dataPoints = [];
        $colIndex = $this->getColumnIndex($spreadsheet, $columnName);
        foreach($dates as list($yIndex, $date)) {
            $cellValue = $spreadsheet->getActiveSheet()->getCellByColumnAndRow($colIndex, $yIndex)->getValue();
            if (!empty($cellValue)) {
                $dataPoint = new DataPoint($columnName, $date, $cellValue);
                $dataPoints[] = $dataPoint;
            }
        }
        return $dataPoints;
    }
}