<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreStudentRequest;
use App\Repositories\StudentRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class StudentController extends Controller
{
    public function __construct(protected StudentRepository $studentRepository)
    {
        //
    }

    public function index()
    {
        $students = $this->studentRepository->findBy(['birthdate' => new \DateTime('1998-01-01')]);

        return Collection::make($students);
    }

    public function store(StoreStudentRequest $request)
    {
        $student = $this->studentRepository->store($request);

        return response()->json($student, 201);
    }
}
