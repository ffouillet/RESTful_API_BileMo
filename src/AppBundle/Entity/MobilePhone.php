<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Hateoas\Configuration\Annotation as Hateoas;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;

/**
 * MobilePhone
 *
 * @ORM\Table(name="mobile_phone")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\MobilePhoneRepository")
 *
 * @ExclusionPolicy("all")
 *
 * @Hateoas\Relation(
 *      "self",
 *      href = @Hateoas\Route(
 *          "show_mobile_phone_details",
 *          parameters = { "id" = "expr(object.getId())" },
 *          absolute = true
 *      )
 * )
 */
class MobilePhone
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     *
     * @Expose
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, unique=true)
     *
     * @Expose
     */
    private $name;

    /**
     * @var float
     *
     * @ORM\Column(name="price", type="float")
     *
     * @Expose
     */
    private $price;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="releasedAt", type="datetime")
     *
     * @Expose
     */
    private $releasedAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="createdAt", type="datetime")
     *
     */
    private $createdAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updatedAt", type="datetime", nullable=true)
     *
     * @Gedmo\Timestampable(on="update")
     */
    private $updatedAt;

    /**
     * @var int
     *
     * @ORM\Column(name="batteryCapacity", type="integer")
     *
     * @Expose
     */
    private $batteryCapacity;

    /**
     * @var int
     *
     * @ORM\Column(name="builtInStorage", type="integer")
     *
     * @Expose
     */
    private $builtInStorage;

    /**
     * @var float
     *
     * @ORM\Column(name="cpuClockSpeed", type="float")
     *
     * @Expose
     */
    private $cpuClockSpeed;

    /**
     * @var int
     *
     * @ORM\Column(name="ram", type="integer")
     *
     * @Expose
     */
    private $ram;

    /**
     * @var int
     *
     * @ORM\Column(name="rearCameraResolution", type="integer")
     *
     * @Expose
     */
    private $rearCameraResolution;

    /**
     * @var int
     *
     * @ORM\Column(name="frontCameraResolution", type="integer", nullable=true)
     *
     * @Expose
     */
    private $frontCameraResolution;

    public function __construct()
    {
        $this->createdAt = new \DateTime();
    }

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return MobilePhone
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set price
     *
     * @param float $price
     *
     * @return MobilePhone
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return float
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set releasedAt
     *
     * @param \DateTime $releasedAt
     *
     * @return MobilePhone
     */
    public function setReleasedAt($releasedAt)
    {
        $this->releasedAt = $releasedAt;

        return $this;
    }

    /**
     * Get releasedAt
     *
     * @return \DateTime
     */
    public function getReleasedAt()
    {
        return $this->releasedAt;
    }

    /**
     * Set batteryCapacity
     *
     * @param integer $batteryCapacity
     *
     * @return MobilePhone
     */
    public function setBatteryCapacity($batteryCapacity)
    {
        $this->batteryCapacity = $batteryCapacity;

        return $this;
    }

    /**
     * Get batteryCapacity
     *
     * @return int
     */
    public function getBatteryCapacity()
    {
        return $this->batteryCapacity;
    }

    /**
     * Set builtInStorage
     *
     * @param integer $builtInStorage
     *
     * @return MobilePhone
     */
    public function setBuiltInStorage($builtInStorage)
    {
        $this->builtInStorage = $builtInStorage;

        return $this;
    }

    /**
     * Get builtInStorage
     *
     * @return int
     */
    public function getBuiltInStorage()
    {
        return $this->builtInStorage;
    }

    /**
     * Set cpuClockSpeed
     *
     * @param float $cpuClockSpeed
     *
     * @return MobilePhone
     */
    public function setCpuClockSpeed($cpuClockSpeed)
    {
        $this->cpuClockSpeed = $cpuClockSpeed;

        return $this;
    }

    /**
     * Get cpuClockSpeed
     *
     * @return float
     */
    public function getCpuClockSpeed()
    {
        return $this->cpuClockSpeed;
    }

    /**
     * Set ram
     *
     * @param integer $ram
     *
     * @return MobilePhone
     */
    public function setRam($ram)
    {
        $this->ram = $ram;

        return $this;
    }

    /**
     * Get ram
     *
     * @return int
     */
    public function getRam()
    {
        return $this->ram;
    }

    /**
     * Set rearCameraResolution
     *
     * @param integer $rearCameraResolution
     *
     * @return MobilePhone
     */
    public function setRearCameraResolution($rearCameraResolution)
    {
        $this->rearCameraResolution = $rearCameraResolution;

        return $this;
    }

    /**
     * Get rearCameraResolution
     *
     * @return int
     */
    public function getRearCameraResolution()
    {
        return $this->rearCameraResolution;
    }

    /**
     * Set frontCameraResolution
     *
     * @param integer $frontCameraResolution
     *
     * @return MobilePhone
     */
    public function setFrontCameraResolution($frontCameraResolution)
    {
        $this->frontCameraResolution = $frontCameraResolution;

        return $this;
    }

    /**
     * Get frontCameraResolution
     *
     * @return int
     */
    public function getFrontCameraResolution()
    {
        return $this->frontCameraResolution;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return MobilePhone
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     *
     * @return MobilePhone
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }
}
