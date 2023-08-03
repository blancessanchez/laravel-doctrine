<?php

namespace App\Repositories;

use App\Entities\School;
use Doctrine\ORM\EntityRepository;

class SchoolRepository extends EntityRepository
{
    /**
     * Create new school
     *
     * @param \Illuminate\Http\Request $data
     * @return School
     */
    public function store($data)
    {
        $school = new School();
        $school->setName($data['name']);

        $this->getEntityManager()->persist($school);
        $this->getEntityManager()->flush();

        return $school;
    }
}