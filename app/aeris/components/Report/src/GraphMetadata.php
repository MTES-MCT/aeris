<?php

namespace Aeris\Component\Report;

class GraphMetadata
{   
    /** var float */
    public $vle;

    /** var string */
    public $label;

    /** var string */
    public $yAxisLabel;

    /** var string */
    public $unit;

    /** var string */
    public $thresholdLabel;

    /**
     * @var string $measureType
     * @var float $vle
     * @var string $labe
     */
    public function __construct(
        $vle,
        $label,
        $yAxisLabel,
        $unit
    ){
        $this->vle = $vle;
        $this->label = $label;
        $this->yAxisLabel = $yAxisLabel;
        $this->unit = $unit;
        $this->thresholdLabel = "Seuil : $vle $unit";
    }

    /**
     * @return mixed
     */
    public function getMeasureType()
    {
        return $this->measureType;
    }
}