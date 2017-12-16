<?php

namespace AppBundle\Repository;

use AppBundle\Entity\Challenge;
use AppBundle\Entity\Image;
use Doctrine\ORM\EntityNotFoundException;
use Faker\Factory;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class ChallengeRepository extends BaseRepository
{
    /**
     * {@inheritdoc}
     */
    public function createChallengePaginator(array $criteria = null, array $sorting = null)
    {
        $queryBuilder = $this->createQueryBuilder('o');

        if (isset($criteria['query'])) {
            $queryBuilder
                ->andWhere($queryBuilder->expr()->like($this->getPropertyName('name'), ':query'))
                ->andWhere($queryBuilder->expr()->like($this->getPropertyName('description'), ':query'))
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

    public function getChallengesQB()
    {
        return $this->createQueryBuilder('o');
    }


    /**
     * @param $id
     *
     * @return Challenge
     * @throws \Doctrine\ORM\EntityNotFoundException
     */
    public function getChallenge($id)
    {
        $challenge = $this->find($id);

        if (!$challenge instanceof Challenge) {
            throw new EntityNotFoundException();
        }

        return $challenge;
    }

    public function bulkRandomInsert(int $size)
    {
        $faker = Factory::create();

        for ($i = 0; $i <= $size; $i++) {
            $rand = random_int(1, 3);

            $image = new Image();
            $image->setImageFile(
                new UploadedFile(
                    __DIR__ . '/../../../web/uploads/drive0/text' . $rand . '.png',
                    'text' . $rand . '.png',
                    'image/png'
                )
            );

            $challenge = new Challenge();
            $challenge->setName($faker->name);
            $challenge->setCorrectAnswer($faker->paragraph);
            $challenge->setDescription($faker->paragraph);
            $challenge->setImage($image);

            $this->persist($challenge);

            if ($i % $size === 0) {
                echo $i . PHP_EOL;
                $this->flush();
                $this->clear();
            }
        }

        $this->flush();
        $this->clear();
    }

    public function getRandom(): Challenge
    {
        $connection = $this->_em->getConnection();

        $randomId = $connection->fetchColumn('SELECT id, RAND() AS rand FROM challenges ORDER BY rand LIMIT 1');

        return $this->find($randomId);
    }
}
