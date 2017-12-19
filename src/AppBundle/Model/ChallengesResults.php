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

    public function addChallengeResult(ChallengeResults $challengeResults): void
    {
        $this->challengesResults->add($challengeResults);
    }
}
