<?php

namespace App\Entities;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Illuminate\Contracts\Support\Arrayable;

/**
 * @ORM\Entity
 * @ORM\Table(name="subjects")
 * @ORM\InheritanceType("JOINED")
 * @ORM\DiscriminatorColumn(name="type", type="integer")
 * @ORM\DiscriminatorMap({1 = "RegularSubject", 2 = "SpecialSubject"})
 */
abstract class Subject implements Arrayable
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @var \DateTime $created
     *
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(name="created_at", type="datetime")
     */
    protected $createdAt;

    /**
     * @var \DateTime $updated
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
     * @ORM\ManyToMany(targetEntity="Student", mappedBy="subjects", cascade={"remove"})
     */
    private $students;

    /**
     * @ORM\OneToOne(targetEntity="RegularSubject", mappedBy="subject", cascade={"remove"})
     */
    private $regularSubject;

    /**
     * @ORM\OneToOne(targetEntity="SpecialSubject", mappedBy="subject", cascade={"remove"})
     */
    private $specialSubject;

    public function __construct()
    {
        $this->students = new ArrayCollection;
    }

    public function getId()
    {
        return $this->id;
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

    public function addStudent(Student $student): void
    {
        if (!$this->students->contains($student)) {
            $this->students->add($student);
            $student->addSubject($this);
        }
    }

    public function removeStudent(Student $student): void
    {
        if ($this->students->contains($student)) {
            $this->students->removeElement($student);
            $student->removeSubject($this);
        }
    }

    public function toArray()
    {
        return [
            'id' => $this->getId(),
            'created_at' => $this->getCreatedAt(),
            'updated_at' => $this->getUpdatedAt(),
            'deleted_at' => $this->getDeletedAt(),
        ];
    }
}