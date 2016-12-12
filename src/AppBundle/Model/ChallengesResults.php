<?php

namespace AppBundle\Model;

use Doctrine\Common\Collections\ArrayCollection;

class ChallengesResults
{
    private $challengesResults;

    public function __construct()
    {
        $this->challengesResults = new ArrayCollection;
    }

    public function addChallengeResult(ChallengeResults $challengeResults, Device $device, Result $result)
    {
        $deviceResult = new DeviceResult($device, $result);

        /** @var ChallengeResults $savedChallenge */
        foreach ($this->challengesResults as $savedChallenge) {
            if ($savedChallenge->getChallenge()->getId() === $challengeResults->getChallenge()->getId()) {
                $savedChallenge->addDeviceResult($deviceResult);

                return;
            }
        }

        $challengeResults->addDeviceResult($deviceResult);
        $this->challengesResults->add($challengeResults);
    }
}
