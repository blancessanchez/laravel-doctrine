<?php

namespace App\Entities;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Illuminate\Contracts\Support\Arrayable;

/**
 * @ORM\Entity
 * @ORM\Table(name="subjects")
 * @ORM\InheritanceType("JOINED")
 * @ORM\DiscriminatorColumn(name="type", type="integer")
 * @ORM\DiscriminatorMap({1 = "RegularSubject", 2 = "SpecialSubject"})
 * @ORM\HasLifecycleCallbacks
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
     * @ORM\Column(type="datetime")
     */
    protected $created_at;

    /**
     * @ORM\Column(type="datetime")
     */
    protected $updated_at;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $deleted_at;

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

    /**
     * @ORM\PrePersist
     */
    public function onPrePersist()
    {
        if (!$this->created_at) {
            $this->created_at = new \Datetime('now');
        }

        if (!$this->updated_at) {
            $this->updated_at = new \Datetime('now');
        }
    }

    /**
     * @ORM\PreUpdate
     */
    public function onPreUpdate()
    {
        $this->updated_at = new \Datetime('now');
    }

    public function __construct()
    {
        $this->students = new ArrayCollection;
    }

    public function getId()
    {
        return $this->id;
    }

    public function toArray()
    {
        return [
            'id' => $this->getId(),
        ];
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
}