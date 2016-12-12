<?php

namespace AppBundle\Model;

use AppBundle\Entity\Challenge;
use Doctrine\Common\Collections\ArrayCollection;

class ChallengeResults
{
    private $challenge;
    private $devicesResults;

    public function __construct(Challenge $challenge)
    {
        $this->challenge = $challenge;
        $this->devicesResults = new ArrayCollection();
    }

    public function getChallenge()
    {
        return $this->challenge;
    }

    public function addDeviceResult(DeviceResult $deviceResult)
    {
        $this->devicesResults->add($deviceResult);
    }
}
