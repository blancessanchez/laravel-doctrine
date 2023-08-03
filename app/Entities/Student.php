<?php

namespace App\Entities;

use App\Entities\Embeddables\Name;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Illuminate\Contracts\Support\Arrayable;

/**
 * @ORM\Entity
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="type", type="integer")
 * @ORM\DiscriminatorMap({1 = "RegularStudent", 2 = "IrregularStudent"})
 * @ORM\Table(name="students")
 * @ORM\HasLifecycleCallbacks
 */
abstract class Student implements Arrayable
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @ORM\Embedded(class="App\Entities\Embeddables\Name")
     */
    private $name;

    /**
     * @ORM\Column(type="date")
     */
    protected $birthdate;

    /**
     * @ORM\Column(type="string", unique=true)
     */
    protected $email;

    /**
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime")
     */
    protected $created_at;

    /**
     * @var \DateTime $updated
     *
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(type="datetime")
     */
    protected $updated_at;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $deleted_at;

    /**
     * @ORM\Column(name="content_changed", type="datetime", nullable=true)
     * @Gedmo\Timestampable(on="change", field={"name_first", "name_last", "email", "birthdate"})
     */
    protected $contentChanged;

    /**
     * @ORM\ManyToOne(targetEntity="School", inversedBy="students")
     * @ORM\JoinColumn(name="school_id", referencedColumnName="id", nullable=true, onDelete="SET NULL")
     * @var School
     */
    protected $school;

    /**
     * @ORM\ManyToMany(targetEntity="Subject", inversedBy="students", cascade={"remove"})
     * @ORM\JoinTable(name="student_subject")
     */
    private $subjects;

    /**
     * @ORM\PrePersist
     */
    // public function onPrePersist()
    // {
    //     if (!$this->created_at) {
    //         $this->created_at = new \Datetime('now');
    //     }

    //     if (!$this->updated_at) {
    //         $this->updated_at = new \Datetime('now');
    //     }
    // }

    /**
     * @ORM\PreUpdate
     */
    // public function onPreUpdate()
    // {
    //     $this->updated_at = new \Datetime('now');
    // }

    public function __construct()
    {
        $this->subjects = new ArrayCollection;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getFullname(): Name
    {
        return $this->name;
    }

    public function setFullname(string $firstname, string $lastname)
    {
        $this->name = new Name($firstname, $lastname);
    }

    public function setBirthdate(\DateTime $birthdate)
    {
        $this->birthdate = $birthdate;
    }

    public function getBirthdate()
    {
        return $this->birthdate;
    }

    public function setEmail(string $email)
    {
        $this->email = $email;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getCreatedAt()
    {
        return $this->created_at;
    }

    public function getUpdatedAt()
    {
        return $this->updated_at;
    }

    public function getDeletedAt()
    {
        return $this->deleted_at;
    }

    public function getContentChanged()
    {
        return $this->contentChanged;
    }

    public function setSchool(School $school)
    {
        $this->school = $school;
    }

    public function getSchool(): ?School
    {
        return $this->school;
    }

   public function getSubjects()
    {
        return $this->subjects;
    }

    public function addSubject(Subject $subject)
    {
        if (!$this->subjects->contains($subject)) {
            $this->subjects->add($subject);
            $subject->addStudent($this); 
        }
    }

    public function removeSubject(Subject $subject)
    {
        if ($this->subjects->contains($subject)) {
            $this->subjects->removeElement($subject);
            $subject->removeStudent($this);
        }
    }

    abstract public function getType();

    public function toArray()
    {
        return [
            'id' => $this->getId(),
            'school' => $this->getSchool()->toArray(),
            'firstname' => $this->getFullname()->getFirstName(),
            'lastname' => $this->getFullname()->getLastName(),
            'birthdate' => $this->getBirthdate(),
            'email' => $this->getEmail(),
            'type' => $this->getType(),
            'created_at' => $this->getCreatedAt(),
            'updated_at' => $this->getUpdatedAt(),
            'deleted_at' => $this->getDeletedAt(),
            'content_changed' => $this->getContentChanged(),
            'subjects' => $this->getSubjects(),
        ];
    }
}