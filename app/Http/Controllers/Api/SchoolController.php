<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repositories\SchoolRepository;
use Illuminate\Http\Request;

class SchoolController extends Controller
{
    protected $schoolRepository;

    public function __construct(SchoolRepository $schoolRepository)
    {
        $this->schoolRepository = $schoolRepository;
    }

    public function store(Request $request)
    {
        $school = $this->schoolRepository->store($request);

        return response()->json($school, 201);
    }

    public function show($id)
    {
        $school = $this->schoolRepository->find($id);

        if (!$school) {
            abort(404, 'School not found');
        }

        return response()->json([$school->toArray()], 200);
    }
}
