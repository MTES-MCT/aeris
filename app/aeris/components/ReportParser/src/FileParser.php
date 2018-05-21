<?php

namespace Aeris\Component\ReportParser;

use PhpOffice\PhpSpreadsheet\IOFactory;

abstract class FileParser {
    abstract function parseFile($filename);

    protected function loadSpreadsheet($inputFilename) {
        $reader = IOFactory::createReaderForFile($inputFilename);
        return $reader->load($inputFilename);
    }

    protected function dateFromExcelDate($excelDate) {
        // requires excelDate to be an integer > 25569
        $timestamp =  ($excelDate - 25569) * 86400;
        return new \DateTime("@$timestamp");
    }
}