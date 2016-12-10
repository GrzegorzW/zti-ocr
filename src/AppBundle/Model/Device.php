<?php

namespace AppBundle\Model;

class Device
{
    private $deviceBrand;
    private $deviceModel;

    public function __construct($deviceBrand, $deviceModel)
    {
        $this->deviceBrand = $deviceBrand;
        $this->deviceModel = $deviceModel;
    }
}
