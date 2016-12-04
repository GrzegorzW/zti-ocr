<?php

namespace AppBundle\Doctrine\ORM;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Id\AbstractIdGenerator;

class Sha512Generator extends AbstractIdGenerator
{
    public function generate(EntityManager $em, $entity)
    {
        return hash('sha512', random_bytes(random_int(16, 128)) . random_int(PHP_INT_MIN, PHP_INT_MAX));
    }
    
    public function isPostInsertGenerator()
    {
        return false;
    }
}
