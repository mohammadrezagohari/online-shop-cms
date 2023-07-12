<?php

namespace App\Http\Controllers;

use App\Http\Requests\city\CityByProvinceRequest;
use App\Http\Requests\city\StoreCityRequest;
use App\Http\Requests\city\UpdateCityRequest;
use App\Http\Requests\SearchRequest;
use App\Http\Resources\city\CityResource;
use App\Http\Resources\province\ProvinceResource;
use App\Models\City;
use App\Repositories\MySQL\CityRepository\InterfaceCityRepository;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response as HTTPResponse;


class CityController extends Controller
{

    private InterfaceCityRepository $interfaceCityRepository;

    public function __construct(InterfaceCityRepository $interfaceCityRepository)
    {
        $this->interfaceCityRepository = $interfaceCityRepository;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(SearchRequest $request): AnonymousResourceCollection
    {
        $count = @$request->count ?? 10;
        $keyword = @$request->keyword;
        $province = @$request->province_id;
        $cities = $this->interfaceCityRepository->query();
        if (@$province)
            $cities = $cities->whereProvinceId($province);

        if (@$keyword)
            $cities = $cities->searchByName($keyword);
        $cities = $cities->paginate($count);
        return CityResource::collection($cities);
    }

    public function list_by_province(CityByProvinceRequest $request): AnonymousResourceCollection
    {
        $count = @$request->count ?? 10;
        $keyword = @$request->keyword;
        $province = @$request->province_id;
        $cities = $this->interfaceCityRepository->query();
        if (@$province)
            $cities = $cities->whereProvinceId($province);

        if (@$keyword)
            $cities = $cities->searchByName($keyword);
        $cities = $cities->paginate($count);
        return CityResource::collection($cities);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCityRequest $request): JsonResponse
    {
        $data=$request->except(["_token"]);
        if($this->interfaceCityRepository->insertData($data))
            return response()->json(['message'=>'successfully your transaction!'],HTTPResponse::HTTP_OK);
        return response()->json(['message'=>'sorry, your transaction fails!'],HTTPResponse::HTTP_BAD_REQUEST);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id): CityResource
    {
        return CityResource::make($this->interfaceCityRepository->findById($id));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(City $city)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCityRequest $request, int $id):JsonResponse
    {
        $data = $request->except(['_token']);
        if($this->interfaceCityRepository->updateItem($id,$data))
            return response()->json(['message' => 'successfully your transaction!'], HTTPResponse::HTTP_OK);
        return response()->json(['message' => 'sorry, your transaction fails!'], HTTPResponse::HTTP_BAD_REQUEST);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id):JsonResponse
    {
        if($this->interfaceCityRepository->deleteData($id))
            return response()->json(['message' => 'successfully your transaction!'], HTTPResponse::HTTP_OK);
        return response()->json(['message' => 'sorry, your transaction fails!'], HTTPResponse::HTTP_BAD_REQUEST);
    }
}
