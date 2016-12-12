<?php

namespace AppBundle\Model;

class Result
{
    private $min;
    private $max;
    private $average;
    private $standardDeviation;
    private $count;

    public function __construct(
        $min,
        $max,
        $average,
        $standardDeviation,
        $count
    ) {
        $this->min = $min;
        $this->max = $max;
        $this->average = $average;
        $this->standardDeviation = $standardDeviation;
        $this->count = $count;
    }
}
