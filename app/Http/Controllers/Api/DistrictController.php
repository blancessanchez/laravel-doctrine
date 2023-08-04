<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repositories\DistrictRepository;
use Illuminate\Http\Request;

class DistrictController extends Controller
{
    public function __construct(protected DistrictRepository $districtRepository)
    {
        //
    }

    public function store(Request $request)
    {
        $district = $this->districtRepository->store($request);

        return response()->json($district, 201);
    }

    public function getDistrictBasedOnStudentId(Request $request)
    {
        $student = $this->districtRepository->getDistrictBasedOnStudentId($request['id']);

        return response()->json($student, 200);
    }

    public function destroy($dataId)
    {
        $district = $this->districtRepository->destroy($dataId);

        return response()->json($district, 200);
    }
}
