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

    public function destroy($id)
    {
        $district = $this->find($id);

        if (!$district) {
            return false;
        }

        $this->getEntityManager()->remove($district);
        $this->getEntityManager()->flush();
    }

    public function update($data, $id)
    {
        $district = $this->find($id);

        if (!$district) {    
            return false;
        }

        if (isset($data['name'])) {
            $district->setName($data['name']);
        }

        if (isset($data['area'])) {
            $district->setArea($data['area']);
        }

        if (isset($data['total_schools'])) {
            $district->setTotalSchools($data['total_schools']);
        }

        if (isset($data['superintendent'])) {
            $district->setSuperintendent($data['superintendent']);
        }

        if (isset($data['phone_no'])) {
            $district->setPhoneNo($data['phone_no']);
        }

        $this->getEntityManager()->persist($district);
        $this->getEntityManager()->flush();

        return $district;
    }
}