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
        $student = $this->districtRepository->getDistrictBasedOnStudentId($request['student-id']);

        return response()->json($student, 200);
    }
    
    /**
     * destroy
     *
     * @param  string $id
     * @return void
     */
    public function destroy($id)
    {
        $district = $this->districtRepository->destroy($id);

        if (!$district) {
            return response()->json(['message' => 'District not found'], 404);
        }

        return response()->json($district, 200);
    }

    public function update(Request $request, $id)
    {
        $district = $this->districtRepository->update($request, $id);

        if (!$district) {
            return response()->json(['message' => 'District not found'], 404);
        }

        return response()->json($district, 200);
    }
}
