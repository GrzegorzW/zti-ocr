<?php

namespace AppBundle\Repository;

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
}
