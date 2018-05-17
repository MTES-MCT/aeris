<?php

namespace Aeris\Component\ReportParser\Parser\Dreal;

class ConcentrationParser extends Parser {
    protected $fields = [
        'debit_horaire_moy_jour',
        'tempf1_24h_moy',
        'tempf2_24h_moy',
        'psr_c_24h_moy',
        'psr_c_30minutes_max',
        'co_c_24h_moy',
        'co_nb_depassements_10min',
        'co_30minutes_max',
        'cot_c_24h_moy',
        'cot_c_30minutes_max',
        'hcl_c_24h_moy',
        'hcl_c_30minutes_max',
        'hf_c_24h_moy',
        'hf_c_30minutes_max',
        'so2_c_24h_moy',
        'so2_c_30minutes_max',
        'nox_c_24h_moy',
        'nox_c_30minutes_max',
        'nh3_c_24h_moy',
        'nh3_c_30minutes_max'
    ];

    protected $initialVerticalOffset = 7;
}