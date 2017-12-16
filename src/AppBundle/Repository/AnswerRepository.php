<?php

namespace AppBundle\Repository;

use AppBundle\Entity\Answer;
use AppBundle\Entity\Challenge;
use Faker\Factory;

class AnswerRepository extends BaseRepository
{
    /**
     * {@inheritdoc}
     */
    public function createAnswerPaginator(array $criteria = null, array $sorting = null)
    {
        $queryBuilder = $this->createQueryBuilder('o');

        if (isset($criteria['query'])) {
            $queryBuilder
                ->andWhere($queryBuilder->expr()->like($this->getPropertyName('timeResult'), ':query'))
                ->andWhere($queryBuilder->expr()->like($this->getPropertyName('deviceBrand'), ':query'))
                ->andWhere($queryBuilder->expr()->like($this->getPropertyName('deviceModel'), ':query'))
                ->andWhere($queryBuilder->expr()->like($this->getPropertyName('deviceOS'), ':query'))
                ->andWhere($queryBuilder->expr()->like($this->getPropertyName('deviceOSVersion'), ':query'))
                ->setParameter('query', '%' . addcslashes($criteria['query'], '%_') . '%');
        }

        if (empty($sorting)) {
            if (!is_array($sorting)) {
                $sorting = [];
            }
            $sorting['updatedAt'] = 'desc';
        }

        $this->applySorting($queryBuilder, $sorting);

        return $this->getPaginator($queryBuilder);
    }

    public function getRawResults()
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = '
          SELECT 
            challenge_id,
            device_brand, 
            device_model, 
            AVG(time_result) AS average, 
            MIN(time_result) AS minimum, 
            MAX(time_result) AS maximum, 
            STD(time_result) as standard_deviation,
            COUNT(*) as counter 
          FROM answers 
          GROUP BY challenge_id, device_brand, device_model;';
        $stmt = $conn->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    public function bulkRandomInsert(Challenge $challenge, int $size)
    {
        $faker = Factory::create();

        for ($i = 0; $i <= $size; $i++) {
            $devices = [
                [
                    'deviceBrand' => 'Apple',
                    'deviceModel' => 'iPhone 6',
                    'deviceOs' => 'OSX',
                    'deviceOsVersion' => '11'
                ], [
                    'deviceBrand' => 'Samsung',
                    'deviceModel' => 'Galaxy S8',
                    'deviceOs' => 'Android',
                    'deviceOsVersion' => '6'
                ]
            ];
            $device = $devices[array_rand($devices)];

            $answer = new Answer();

            $answer->setDeviceBrand($device['deviceBrand']);
            $answer->setDeviceModel($device['deviceModel']);
            $answer->setDeviceOS($device['deviceOs']);
            $answer->setDeviceOSVersion($device['deviceOsVersion']);

            $answer->setContent($faker->text());
            $answer->setChallenge($challenge);
            $answer->setTimeResult($faker->randomFloat(5, 3, 15));

            $this->persist($answer);


            if ($i % $size === 0) {
                echo $i . PHP_EOL;
                $this->flush();
                $this->clear();
            }
        }
    }
}
