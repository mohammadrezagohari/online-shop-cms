<?php

namespace App\Http\Controllers;

use App\Http\Requests\basicInfo\BasicInfoRequest;
use App\Http\Requests\basicInfo\StoreBasicInfoRequest;
use App\Http\Requests\basicInfo\UpdateBasicInfoRequest;
use App\Http\Resources\basicInfo\BasicInfoResource;
use App\Repositories\MySQL\BasicInfoRepository\InterfaceBasicInfoRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Symfony\Component\HttpFoundation\Response as HTTPResponse;


class BasicInfoController extends Controller
{

    private InterfaceBasicInfoRepository $interfaceBasicInfoRepository;
    public function __construct(InterfaceBasicInfoRepository $interfaceBasicInfoRepository)
    {
        $this->interfaceBasicInfoRepository = $interfaceBasicInfoRepository;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(BasicInfoRequest $request): AnonymousResourceCollection
    {
        $count = @$request->count ?? 10;
        $key = @$request->key;
        $value = @$request->value;
        $basicInfos = $this->interfaceBasicInfoRepository->query();

        if (@$key)

            $basicInfos = $basicInfos->whereKeyInput($key);


        if (@$value)
            $basicInfos = $basicInfos->whereValue($value);


        return BasicInfoResource::collection($basicInfos->paginate($count));
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
    public function store(StoreBasicInfoRequest $request): JsonResponse
    {
        $data = $request->except(['_token']);

        if ($this->interfaceBasicInfoRepository->insertData($data))
            return response()->json(['message' => 'successfully your transaction!'], HTTPResponse::HTTP_OK);
        return response()->json(['message' => 'sorry, your transaction fails!'], HTTPResponse::HTTP_BAD_REQUEST);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        return BasicInfoResource::make($this->interfaceBasicInfoRepository->findById($id));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBasicInfoRequest $request, int $id)
    {
        $data = $request->except(['_token']);

        if ($this->interfaceBasicInfoRepository->updateItem($id, $data))
            return response()->json(['message' => 'successfully your transaction!'], HTTPResponse::HTTP_OK);
        return response()->json(['message' => 'sorry, your transaction fails!'], HTTPResponse::HTTP_BAD_REQUEST);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        if ($this->interfaceBasicInfoRepository->deleteData($id))
        return response()->json(['message' => 'successfully your transaction!'], HTTPResponse::HTTP_OK);
    return response()->json(['message' => 'sorry, your transaction fails!'], HTTPResponse::HTTP_BAD_REQUEST);
    }
}
