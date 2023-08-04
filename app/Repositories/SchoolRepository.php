<?php

namespace App\Repositories;

use App\Entities\District;
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

        $district = $this
            ->getEntityManager()
            ->getRepository(District::class)
            ->find($data['district_id']);

        if (!$district) {
            throw new \Exception('Invalid district id provided');
        }

        $school->setDistrict($district);

        $this->getEntityManager()->persist($school);
        $this->getEntityManager()->flush();

        return $school;
    }
}