<?php

namespace AppBundle\Entity;

use ModernFactory\ResourcesBundle\Resource\Model\ResourceInterface;

class Answer implements ResourceInterface
{
    /** @var integer */
    protected $id;
    /** @var \DateTime */
    protected $createdAt;
    /** @var \DateTime */
    protected $updatedAt;
    /** @var string */
    protected $content;
    /** @var Challenge */
    protected $challenge;
    /** @var string */
    protected $deviceBrand;
    /** @var string */
    protected $deviceModel;
    /** @var string */
    protected $deviceOS;
    /** @var string */
    protected $deviceOSVersion;
    /** @var string */
    protected $timeResult;

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
    public function getDeviceBrand()
    {
        return $this->deviceBrand;
    }

    /**
     * @param string $deviceBrand
     */
    public function setDeviceBrand($deviceBrand)
    {
        $this->deviceBrand = $deviceBrand;
    }

    /**
     * @return string
     */
    public function getDeviceModel()
    {
        return $this->deviceModel;
    }

    /**
     * @param string $deviceModel
     */
    public function setDeviceModel($deviceModel)
    {
        $this->deviceModel = $deviceModel;
    }

    /**
     * @return string
     */
    public function getDeviceOS()
    {
        return $this->deviceOS;
    }

    /**
     * @param string $deviceOS
     */
    public function setDeviceOS($deviceOS)
    {
        $this->deviceOS = $deviceOS;
    }

    /**
     * @return string
     */
    public function getDeviceOSVersion()
    {
        return $this->deviceOSVersion;
    }

    /**
     * @param string $deviceOSVersion
     */
    public function setDeviceOSVersion($deviceOSVersion)
    {
        $this->deviceOSVersion = $deviceOSVersion;
    }

    /**
     * @return string
     */
    public function getTimeResult()
    {
        return $this->timeResult;
    }

    /**
     * @param string $timeResult
     */
    public function setTimeResult($timeResult)
    {
        $this->timeResult = $timeResult;
    }

    public function isCorrect()
    {
        return strtolower($this->getContent()) === strtolower($this->getChallenge()->getCorrectAnswer());
    }

    /**
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param string $content
     */
    public function setContent($content)
    {
        $this->content = $content;
    }

    /**
     * @return Challenge
     */
    public function getChallenge()
    {
        return $this->challenge;
    }

    /**
     * @param Challenge $challenge
     */
    public function setChallenge(Challenge $challenge)
    {
        $this->challenge = $challenge;
    }
}
