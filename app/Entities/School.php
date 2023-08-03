<?php

namespace App\Entities;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Illuminate\Contracts\Support\Arrayable;

/**
 * @ORM\Entity
 * @ORM\Table(name="schools")
 * @ORM\HasLifecycleCallbacks
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
     * @ORM\OneToMany(targetEntity="Student", mappedBy="school", cascade={"persist"})
     * @var ArrayCollection|Student[]
     */
    protected $students;

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

    public function setName(string $name)
    {
        $this->name = $name;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getStudents()
    {
        return $this->students;
    }

    public function setCreated()
    {
        $this->created_at = new \Datetime('now');
    }

    public function setUpdated()
    {
        $this->updated_at = new \Datetime('now');
    }

    public function toArray()
    {
        return [
            'id' => $this->getId(),
            'name' => $this->getName(),
            'students' => $this->getStudents(),
        ];
    }
}