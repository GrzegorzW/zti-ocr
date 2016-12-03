<?php

namespace AppBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use ModernFactory\ResourcesBundle\Resource\Model\ResourceInterface;

/**
 * @UniqueEntity("emailCanonical")
 */
class User extends BaseUser implements ResourceInterface
{
    const ROLE_USER = 'ROLE_USER';
    const ROLE_ADMIN = 'ROLE_ADMIN';

    /** @var \DateTime */
    protected $createdAt;
    /** @var \DateTime */
    protected $updatedAt;

    public function __construct()
    {
        parent::__construct();
        $this->enabled = true;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @param \DateTime $createdAt
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * @param \DateTime $updatedAt
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;
    }

    /**
     * @param string $email
     * @return $this|\FOS\UserBundle\Model\UserInterface
     */
    public function setEmail($email)
    {
        parent::setEmail($email);
        $this->setUsername($email);

        return $this;
    }
}
