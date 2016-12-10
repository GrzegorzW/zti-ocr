<?php

namespace AppBundle\Model;

use Doctrine\Common\Collections\ArrayCollection;

class Results
{
    private $results;

    public function __construct()
    {
        $this->results = new ArrayCollection();
    }

    public function addResult(Result $result)
    {
        $this->results->add($result);
    }
}
