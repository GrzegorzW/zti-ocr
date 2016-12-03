<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use ModernFactory\ResourcesBundle\Resource\Model\ResourceInterface;

class Challenge implements ResourceInterface
{
    const STATUS_ENABLED = 'enabled';
    const STATUS_DISABLED = 'disabled';

    /** @var integer */
    protected $id;
    /** @var \DateTime */
    protected $createdAt;
    /** @var \DateTime */
    protected $updatedAt;
    /** @var  string */
    protected $status;
    /** @var string */
    protected $description;
    /** @var Image */
    protected $image;
    /** @var Answer */
    protected $answers;

    public function __construct()
    {
        $this->answers = new ArrayCollection();
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
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
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param string $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return Image
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @param Image $image
     */
    public function setImage(Image $image)
    {
        $this->image = $image;
        $this->image->setChallenge($this);
    }

    /**
     * @return Answer
     */
    public function getAnswers()
    {
        return $this->answers;
    }

    /**
     * @param Answer $answers
     */
    public function setAnswers(Answer $answers)
    {
        $this->answers = $answers;
        $answers->setChallenge($this);
    }
}
