<?php

namespace AppBundle\Service;

use AppBundle\Model\ChallengeResults;
use AppBundle\Model\ChallengesResults;
use AppBundle\Model\Device;
use AppBundle\Model\Result;
use AppBundle\Repository\ChallengeRepository;

class AnswerManager
{
    private $challengeRepository;

    public function __construct(ChallengeRepository $challengeRepository)
    {
        $this->challengeRepository = $challengeRepository;
    }

    /**
     * @param array $rawResults
     * @return ChallengesResults
     * @throws \Doctrine\ORM\EntityNotFoundException
     */
    public function transformRaw(array $rawResults)
    {
        $results = new ChallengesResults();

        foreach ($rawResults as $rawResult) {
            $challenge = $this->challengeRepository->getChallenge($rawResult['challenge_id']);
            $challengeResults = new ChallengeResults($challenge);
            $device = new Device($rawResult['device_brand'], $rawResult['device_model']);
            $result = new Result(
                $rawResult['minimum'],
                $rawResult['maximum'],
                $rawResult['average'],
                $rawResult['standard_deviation'],
                $rawResult['counter']
            );

            $results->addChallengeResult($challengeResults, $device, $result);
        }

        return $results;
    }
}
