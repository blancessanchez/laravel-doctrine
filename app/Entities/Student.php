<?php

namespace App\Entities;

use App\Entities\Embeddables\Address;
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
     * @ORM\Embedded(class="App\Entities\Embeddables\Address")
     */
    private $address;

    /**
     * @ORM\Column(type="date")
     */
    protected $birthdate;

    /**
     * @ORM\Column(type="string", unique=true)
     */
    protected $email;

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

    public function getAddress(): Address
    {
        return $this->address;
    }

    public function setFullname(string $firstname, string $lastname)
    {
        $this->name = new Name($firstname, $lastname);
    }

    public function setAddress(
        string $street,
        string $postalCode,
        string $city,
        string $country
    )
    {
        $this->address = new Address($street, $postalCode, $city, $country);
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
            'street' => $this->getAddress()->getStreet(),
            'postal_code' => $this->getAddress()->getPostalCode(),
            'city' => $this->getAddress()->getCity(),
            'country' => $this->getAddress()->getCountry(),
            'birthdate' => $this->getBirthdate(),
            'email' => $this->getEmail(),
            'type' => $this->getType(),
            'created_at' => $this->getCreatedAt(),
            'updated_at' => $this->getUpdatedAt(),
            'deleted_at' => $this->getDeletedAt(),
            'content_changed' => $this->getContentChanged(),
            'subjects' => $this->getSubjects()->toArray(),
        ];
    }
}