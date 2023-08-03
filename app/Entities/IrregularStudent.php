<?php

namespace App\Entities;

use App\Enums\StudentType;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class IrregularStudent extends Student
{
    public function getType()
    {
        return StudentType::Irregular->name;
    }
}