<?php

namespace App\Entities;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Illuminate\Contracts\Support\Arrayable;
use Money\Money;

/**
 * @ORM\Entity
 * @ORM\Table(name="schools")
 */
class School implements Arrayable
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
     * @ORM\Column(type="money", nullable=true)
     */
    private $price;

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
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(name="updated_at",type="datetime")
     */
    protected $updatedAt;

    /**
     * @ORM\Column(name="deleted_at", type="datetime", nullable=true)
     */
    protected $deletedAt;

    /**
     * @ORM\ManyToOne(targetEntity="District", inversedBy="schools")
     * @ORM\JoinColumn(name="district_id", referencedColumnName="id", nullable=true, onDelete="SET NULL")
     * @var District
     */
    protected $district;

    /**
     * @ORM\OneToMany(targetEntity="Student", mappedBy="school", cascade={"persist"})
     * @var ArrayCollection|Student[]
     */
    protected $students;

    public function __construct()
    {
        $this->students = new ArrayCollection;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setName(string $name)
    {
        $this->name = $name;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setPrice(Money $price): void
    {
        $this->price = $price;
    }

    public function getPrice()
    {
        return $this->price;
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

    public function setDistrict(District $district)
    {
        $this->district = $district;
    }

    public function getDistrict(): ?District
    {
        return $this->district;
    }

    public function getStudents()
    {
        return $this->students;
    }

    public function toArray()
    {
        return [
            'id' => $this->getId(),
            'name' => $this->getName(),
            'price' => $this->getPrice(),
            'created_at' => $this->getCreatedAt(),
            'updated_at' => $this->getUpdatedAt(),
            'deleted_at' => $this->getDeletedAt(),
            'students' => $this->getStudents(),
        ];
    }
}