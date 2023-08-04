<?php

namespace App\Entities;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Illuminate\Contracts\Support\Arrayable;

/**
 * @ORM\Entity
 * @ORM\Table(name="districts")
 */
class District implements Arrayable
{
    /**
     * @ORM\Id
     * @ORM\Column(name="id", type="guid")
     * @ORM\GeneratedValue(strategy="UUID")
     */
    protected $id;

    /**
     * @ORM\Column(type="string")
     */
    protected $name;

    /**
     * @ORM\Column(type="float")
     */
    protected $area;

    /**
     * @ORM\Column(name="total_schools", type="integer", nullable=true, options={"default" : 0})
     */
    protected $totalSchools;

    /**
     * @ORM\Column(type="string")
     */
    protected $superintendent;

    /**
     * @ORM\Column(name="phone_no", type="string")
     */
    protected $phoneNo;

    /**
     * @var \DateTime $createdAt
     *
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(name="created_at", type="datetime")
     */
    protected $createdAt;

    /**
     * @var \DateTime $updatedAt
     *
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(name="updated_at", type="datetime")
     */
    protected $updatedAt;

    /**
     * @ORM\Column(name="deleted_at", type="datetime", nullable=true)
     */
    protected $deletedAt;

    /**
     * @ORM\OneToMany(targetEntity="School", mappedBy="district", cascade={"persist"})
     * @var ArrayCollection|School[]
     */
    protected $schools;

    public function getId()
    {
        return $this->id;
    }

    public function setName(string $name)
    {
        $this->name = $name;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setArea(float $area)
    {
        $this->area = $area;
    }

    public function getArea(): float
    {
        return $this->area;
    }

    public function getTotalSchools(): int
    {
        return $this->totalSchools;
    }

    public function setTotalSchools(?int $totalSchools)
    {
        $this->totalSchools = $totalSchools;
    }

    public function getSuperintendent(): string
    {
        return $this->superintendent;
    }

    public function setSuperintendent(string $superintendent)
    {
        $this->superintendent = $superintendent;
    }

    public function getPhoneNo(): string
    {
        return $this->phoneNo;
    }

    public function setPhoneNo(string $phoneNo)
    {
        $this->phoneNo = $phoneNo;
    }

    public function getSchools()
    {
        return $this->schools;
    }

    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    public function getDeletedAt()
    {
        return $this->deletedAt;
    }

    public function toArray()
    {
        return [
            'id' => $this->getId(),
            'district_name' => $this->getName(),
            'area' => $this->getArea(),
            'totalSchools' => $this->getSchools(),
            'superintendent' => $this->getSuperintendent(),
            'phone_no' => $this->getPhoneNo(),
            'created_at' => $this->getCreatedAt(),
            'updated_at' => $this->getUpdatedAt(),
            'deleted_at' => $this->getDeletedAt(),
        ];
    }
}