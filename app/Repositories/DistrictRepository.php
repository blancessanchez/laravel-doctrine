<?php

namespace App\Repositories;

use App\Entities\District;
use App\Entities\School;
use Doctrine\ORM\EntityRepository;
use Money\Money;
use Money\Currency;

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

        $school = new School();
        $school->setName($data['school']);
        $school->setPrice(new Money($data['amount'], new Currency($data['currency'])));

        $district->addSchool($school);

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

    public function destroy($data)
    {
        $district = $this->find($data);

        if (!$district) {
            return false;
        }

        $this->getEntityManager()->remove($district);
        $this->getEntityManager()->flush();
    }
}