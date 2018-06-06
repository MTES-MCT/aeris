<?php

namespace Aeris\Component\Report\Validator;

use Symfony\Component\Validator\Constraint;

class IsInMonthlyRange extends Constraint
{
    public $message = 'The value is not in the allowed range';

    public $field;
    public $min;
    public $max;

    public function __construct($field, $min, $max) {
        $this->field = $field;
        $this->min = $min;
        $this->max = $max;
    }

    public function getTargets()
    {
        return self::CLASS_CONSTRAINT;
    }
}