<?php

namespace Aeris\Component\ReportParser;

class DataPoint {
    /** @var \DateTime */
    public $date;
    /** @var string */
    public $type;
    /** @var mixed */
    public $value;

    public function __construct($type, $date, $value) {
        $this->type = $type;
        $this->date = $date;
        $this->value = $value;
    }
}