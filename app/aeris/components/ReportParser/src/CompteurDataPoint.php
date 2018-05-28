<?php

namespace Aeris\Component\ReportParser;

class CompteurDataPoint {
    /** @var string */
    public $type;
    /** @var string */
    public $component;
    /** @var int */
    public $value;

    public function __construct($type, $component, $value) {
        $this->type = $type;
        $this->component = $component;
        $this->value = $value;
    }
}