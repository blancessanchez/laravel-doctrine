<?php

namespace App\Repositories;

use App\Entities\District;
use Doctrine\ORM\EntityRepository;

class DistrictRepository extends EntityRepository
{
    /**
     * Create new district
     *
     * @param \Illuminate\Http\Request $data
     * @return District
     */
    public function store($data)
    {
        $district = new District();

        $district->setName($data['name']);
        $district->setArea($data['area']);
        $district->setTotalSchools($data['total_schools']);
        $district->setSuperintendent($data['superintendent']);
        $district->setPhoneNo($data['phone_no']);

        $this->getEntityManager()->persist($district);
        $this->getEntityManager()->flush();

        return $district;
    }

    /**
     * Get all schools and students based on student
     * 
     */
    public function getDistrictBasedOnStudentId($studentSchoolId)
    {
        return $this->createQueryBuilder('d')
            ->innerJoin('d.schools', 's')
            ->innerJoin('s.students', 'st')
            ->where('st.id = :studentId')
            ->setParameter('studentId', $studentSchoolId)
            ->getQuery()
            ->getOneOrNullResult();
    }
}