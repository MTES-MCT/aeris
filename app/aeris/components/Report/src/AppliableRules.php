<?php

namespace Aeris\Component\Report;

class AppliableRules {
    public $fields = [
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
        'nh3_c_30minutes_max',
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

    const compteursTypes = [
        'compt_art10_mensuel',
        'nb_dep_4h_mensuel',
        'nb_dep_c_moy_24h_mensuel',
        'nb_dep_f_24h_mensuel',
        'nb_moy_24h_invalides_mensuel'
    ];

// Dépassement VLE article 10 (h)  
// Nombre de dépassements de la concentration moyenne journalière (j)
// Nombre de dépassements du flux journalier (j)
// Nombre de dépassements > 4h 

    const compteursComponents = [
        'Poussières',
        'CO',
        'COT',
        'HCl',
        'HF',
        'SO2',
        'NOX',
        'NH3',
        'Total'
    ];
}