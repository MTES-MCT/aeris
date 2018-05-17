<?php

namespace Aeris\Component\ReportParser\Parser\Dreal;

class FluxParser extends Parser {
    protected $fields = [
        'psr_f_24h',
        'psr_f_1h_max',
        'co_f_24h',
        'co_f_1h_max',
        'cot_f_24h',
        'cot_f_1h_max',
        'hcl_f_24h',
        'hcl_f_1h_max',
        'hf_f_24h',
        'hf_f_1h_max',
        'so2_f_24h',
        'so2_f_1h_max',
        'nox_f_24h',
        'nox_f_1h_max',
        'nh3_f_24h',
        'nh3_f_1h_max'
    ];

    protected $initialVerticalOffset = 7;
}