<?php

namespace AppBundle\Repository;

use ModernFactory\ResourcesBundle\Resource\Repository\RepositoryInterface;

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

    public function getChallengesQB() {

        $qb = $this->createQueryBuilder('o')
            ->addOrderBy('o.name', RepositoryInterface::ORDER_ASCENDING);

        return $qb;
    }
}
