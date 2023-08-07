<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repositories\DistrictRepository;
use Illuminate\Http\Request;

class DistrictController extends Controller
{    
    /**
     * __construct
     *
     * @param  DistrictRepository $districtRepository
     * @return void
     */
    public function __construct(protected DistrictRepository $districtRepository)
    {
        //
    }

    /**
     * store
     *
     * @param  \Illuminate\Http\Request $request
     * @return void
     */
    public function store(Request $request)
    {
        $district = $this->districtRepository->store($request);

        return response()->json($district, 201);
    }

    /**
     * getDistrictBasedOnStudentId
     *
     * @param  \Illuminate\Http\Request $request
     * @return void
     */
    public function getDistrictBasedOnStudentId(Request $request)
    {
        $student = $this->districtRepository->getDistrictBasedOnStudentId($request['id']);

        return response()->json($student, 200);
    }
    
    /**
     * destroy
     *
     * @param  string $dataId
     * @return void
     */
    public function destroy($dataId)
    {
        $district = $this->districtRepository->destroy($dataId);

        return response()->json($district, 200);
    }
}
