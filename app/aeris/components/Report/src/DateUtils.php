<?php

namespace Aeris\Component\Report;

class DateUtils {
    public static function getFirstOfJanuaryThisYear(){
        $year = new \DateTime();
        $year->setDate($year->format('Y'), 1, 1);
        $year->setTime(0, 0, 0);

        return $year;
    }
}