<?php

namespace App\Entities\Embeddables;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Embeddable()
 */
class Name
{
    /**
     * @ORM\Column(type="string", length=255)
     */
    private $first;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $last;

    public function __construct(string $firstname, string $lastname)
    {
        $this->first = $firstname;
        $this->last = $lastname;
    }

    public function getFirstName(): string
    {
        return $this->first;
    }

    public function getLastName(): string
    {
        return $this->last;
    }

    public function __toString(): string
    {
        return "{$this->first} {$this->last}";
    }
}