<?php

namespace App\Http\Controllers;

use App\Http\Requests\province\StoreProvinceRequest;
use App\Http\Requests\province\UpdateProvinceRequest;
use App\Http\Requests\SearchRequest;
use App\Http\Resources\province\ProvinceResource;
use App\Models\Province;
use App\Repositories\MySQL\ProvinceRepository\InterfaceProvinceRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Symfony\Component\HttpFoundation\Response as HTTPResponse;
/**
 * @group Province
 *
 *API endpoints for Province Services
 *
 *
 */
class ProvinceController extends Controller
{

    private InterfaceProvinceRepository $interfaceProvinceRepository;


    public function __construct(InterfaceProvinceRepository $interfaceProvinceRepository)
    {
        $this->interfaceProvinceRepository = $interfaceProvinceRepository;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(SearchRequest $request)
    {
        $count = @$request->count ?? 10;
        $keyword = @$request->keyword;

        $result = $this->interfaceProvinceRepository->query();
        if (@$keyword)
            $result = $result->searchByName($keyword);

        $result = $result->paginate($count);
        return ProvinceResource::collection($result);
    }


    public function search(SearchRequest $request): AnonymousResourceCollection
    {
        $count = @$request->count ?? 10;
        $keyword = @$request->keyword;
        $result = $this->interfaceProvinceRepository->query()->searchByName($keyword)->paginate($count);
        return ProvinceResource::collection($result);
    }



    public function list(): AnonymousResourceCollection
    {
        return ProvinceResource::collection($this->interfaceProvinceRepository->getAll());
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
    public function store(StoreProvinceRequest $request): JsonResponse
    {
        $data = $request->except(["_token"]);
        if ($this->interfaceProvinceRepository->insertData($data))
            return response()->json(['message' => 'successfully your transaction!'], HTTPResponse::HTTP_OK);
        return response()->json(['message' => 'sorry, your transaction fails!'], HTTPResponse::HTTP_BAD_REQUEST);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id): ProvinceResource
    {
        return ProvinceResource::make($this->interfaceProvinceRepository->findById($id));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Province $province)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProvinceRequest $request, int $id)
    {

        $data = $request->except(['_token']);
        if ($this->interfaceProvinceRepository->updateItem($id, $data))
            return response()->json(['message' => 'successfully your transaction!'], HTTPResponse::HTTP_OK);
        return response()->json(['message' => 'sorry, your transaction fails!'], HTTPResponse::HTTP_BAD_REQUEST);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id): JsonResponse
    {
        if ($this->interfaceProvinceRepository->deleteData($id))
            return response()->json(['message' => 'successfully your transaction !'], HTTPResponse::HTTP_OK);
        return response()->json(['message' => 'sorry, your transaction fails!'], HTTPResponse::HTTP_BAD_REQUEST);
    }
}
