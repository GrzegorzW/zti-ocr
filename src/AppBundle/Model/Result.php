<?php

namespace AppBundle\Model;

class Result
{
    private $device;
    private $min;
    private $max;
    private $average;
    private $standardDeviation;
    private $count;

    public function __construct(Device $device, $min, $max, $average, $standardDeviation, $count)
    {
        $this->device = $device;
        $this->min = $min;
        $this->max = $max;
        $this->average = $average;
        $this->standardDeviation = $standardDeviation;
        $this->count = $count;
    }
}
