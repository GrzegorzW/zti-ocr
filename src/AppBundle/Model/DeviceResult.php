<?php

namespace AppBundle\Model;

class DeviceResult
{
    private $device;
    private $result;

    public function __construct(Device $device, Result $result)
    {
        $this->device = $device;
        $this->result = $result;
    }

    /**
     * @return Device
     */
    public function getDevice()
    {
        return $this->device;
    }

    /**
     * @return Result
     */
    public function getResult()
    {
        return $this->result;
    }
}
