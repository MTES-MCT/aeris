<?php

namespace Aeris\Component\Report\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class IsInMonthlyRangeValidator extends ConstraintValidator
{
    public function validate($monthlyReport, Constraint $constraint)
    {
        // echo "Validating !";

        for($i = 1; $i < $monthlyReport->nbDaysInMonth; ++$i) {
            $value = $monthlyReport->dailyData[$i][$constraint->field];
            if(!empty($value) && ($value < $constraint->min || $value > $constraint->max)) {

                $this->context->buildViolation($constraint->field)
                    ->addViolation();

                break;
            } 
        }
    }
}