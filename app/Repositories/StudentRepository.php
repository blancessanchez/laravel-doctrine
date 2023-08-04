<?php

namespace App\Repositories;

use App\Enums\StudentType;
use App\Entities\IrregularStudent;
use App\Entities\RegularStudent;
use App\Entities\School;
use App\Entities\Student;
use App\Entities\Subject;
use Doctrine\ORM\EntityRepository;

class StudentRepository extends EntityRepository
{
    /**
     * Get all students
     * 
     * @return Student[]
     */
    public function index()
    {
        return $this->createQueryBuilder('s')
            ->leftJoin('s.school', 'school')
            ->addSelect('school')
            ->getQuery()
            ->getResult();
    }

    /**
     * Get student by ID
     *
     * @param integer $id
     * @return Student|null
     */
    public function show($id)
    {
        return $this->find($id);
    }

    public function createStudentBasedOnType($type)
    {
        if ($type == StudentType::Regular->value) {
            return new RegularStudent();
        } else if ($type == StudentType::Irregular->value) {
            return new IrregularStudent();
        }

        throw new \InvalidArgumentException('Invalid student type provided');
    }

    /**
     * Create new student
     *
     * @param \App\Http\Requests\StoreStudentRequest $data
     * @return RegularStudent|IrregularStudent
     */
    public function store($data)
    {
        $student = $this->createStudentBasedOnType($data['type']);

        $student->setFullname($data['firstname'], $data['lastname']);
        $student->setAddress(
            $data['street'],
            $data['postal_code'],
            $data['city'],
            $data['country'],
        );
        $student->setBirthdate(new \DateTime($data['birthdate']));
        $student->setEmail($data['email']);

        $school = $this->getEntityManager()->getRepository(School::class)->find($data['school_id']);

        if (!$school) {
            throw new \Exception('Invalid school id provided');
        }

        $student->setSchool($school);

        $this->getEntityManager()->persist($student);
        $this->getEntityManager()->flush();

        return $student;
    }

    public function addSubjectToStudent(Student $student, array $subjectIds): void
    {
        $subjects = $this->getEntityManager()->getRepository(Subject::class)->findBy(['id' => $subjectIds]);

        foreach ($subjects as $subject) {
            $student->addSubject($subject);
        }

        $this->getEntityManager()->flush();
    }

    public function removeSubjectFromStudent(Student $student, array $subjectIds): void
    {
        $subjects = $this->getEntityManager()->getRepository(Subject::class)->findBy(['id' => $subjectIds]);

        foreach ($subjects as $subject) {
            $student->removeSubject($subject);
        }

        $this->getEntityManager()->flush();
    }
}