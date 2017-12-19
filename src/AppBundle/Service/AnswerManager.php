<?php

namespace AppBundle\Service;

use AppBundle\Entity\Challenge;
use AppBundle\Model\ChallengeResults;
use AppBundle\Model\ChallengesResults;
use AppBundle\Model\Device;
use AppBundle\Model\DeviceResult;
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
     *
     * @return ChallengesResults
     */
    public function transformRaw(array $rawResults)
    {
        $mappedResults = $this->mapRawResults($rawResults);

        $results = new ChallengesResults();

        /** @var Challenge $challenge */
        foreach ($this->getAllChallenges() as $challenge) {
            if (!isset($mappedResults[$challenge->getId()->toString()])) {
                continue;
            }

            $challengeResults = new ChallengeResults($challenge);

            foreach ($mappedResults[$challenge->getId()->toString()] as $rawResult) {
                $device = new Device($rawResult['device_brand'], $rawResult['device_model']);
                $result = new Result(
                    $rawResult['minimum'],
                    $rawResult['maximum'],
                    $rawResult['average'],
                    $rawResult['standard_deviation'],
                    $rawResult['counter']
                );

                $deviceResult = new DeviceResult($device, $result);

                $challengeResults->addDeviceResult($deviceResult);
            }

            $results->addChallengeResult($challengeResults);
        }

        return $results;
    }

    /**
     * @param array $results
     *
     * @return array
     */
    private function mapRawResults(array $results): array
    {
        return array_reduce(
            $results,
            function ($carry, $current) {
                if (!isset($carry[$current['challenge_id']])) {
                    $carry[$current['challenge_id']] = [];
                }

                $carry[$current['challenge_id']][] = $current;

                return $carry;
            },
            []
        );
    }

    /**
     * @return array
     */
    private function getAllChallenges(): array
    {
        return $this->challengeRepository->findAll();
    }
}
