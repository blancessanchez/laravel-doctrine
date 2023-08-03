<?php

namespace App\Entities;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class SpecialSubject extends Subject
{
    /**
     * @ORM\Column(type="string")
     */
    protected $name;

    /**
     * @ORM\OneToOne(targetEntity="Subject", inversedBy="subject", cascade={"remove"})
     * @ORM\JoinColumn(name="subject_id", referencedColumnName="id")
     */
    private $subject;

    public function setName(string $name)
    {
        $this->name = $name;
    }

    public function getName()
    {
        return $this->name;
    }

    public function toArray()
    {
        return [
            'id' => $this->getId(),
            'name' => $this->getName(),
        ];
    }
}