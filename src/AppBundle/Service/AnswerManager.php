<?php

namespace AppBundle\Service;

use AppBundle\Model\Device;
use AppBundle\Model\Result;
use AppBundle\Model\Results;

class AnswerManager
{
    public function transformResults(array $rawResults)
    {
        $results = new Results();

        foreach ($rawResults as $rawResult) {
            $device = new Device($rawResult['device_brand'], $rawResult['device_model']);
            $result = new Result(
                $device,
                $rawResult['minimum'],
                $rawResult['maximum'],
                $rawResult['average'],
                $rawResult['standard_deviation'],
                $rawResult['counter']);

            $results->addResult($result);
        }

        return $results;
    }
}
