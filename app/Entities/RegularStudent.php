<?php

namespace App\Entities;

use App\Enums\StudentType;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class RegularStudent extends Student
{
    public function getType()
    {
        return StudentType::Regular->name;
    }
}