<?php
require __DIR__.'/../../../vendor/autoload.php';
date_default_timezone_set('Europe/Paris');

use Aeris\Component\ReportParser\Parser\Dreal\ConcentrationParser as DrealConcentrationParser;
use Aeris\Component\ReportParser\Parser\Dreal\FluxParser as DrealFluxParser;
use Aeris\Component\ReportParser\Parser\Dreal\CompteursParser as DrealCompteursParser;

$parser = new DrealConcentrationParser();
$inputFileName = __DIR__ . '/sample-data/sample-concentrations.xls';
$datapoints = $parser->parseFile($inputFileName);

echo var_dump($datapoints);

$parser = new DrealFluxParser();
$inputFileName = __DIR__ . '/sample-data/sample-flux.xls';
$datapoints = $parser->parseFile($inputFileName);

echo var_dump($datapoints);

$parser = new DrealCompteursParser();
$inputFileName = __DIR__ . '/sample-data/sample-compteurs.xls';
$datapoints = $parser->parseFile($inputFileName);

echo var_dump($datapoints);