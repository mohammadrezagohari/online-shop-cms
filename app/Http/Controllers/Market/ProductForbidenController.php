<?php

namespace App\Http\Controllers\Market;

use App\Http\Controllers\Controller;
use App\Http\Requests\productForbiden\ProductForbidenRequest;
use App\Http\Requests\productForbiden\StoreProductForbidenRequest;
use App\Http\Requests\productForbiden\UpdateProductForbidenRequest;
use App\Http\Resources\productForbiden\ProductForbidenResource;
use App\Repositories\MySQL\ProductForbidenRepository\InterfaceProductForbidenRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Symfony\Component\HttpFoundation\Response as HTTPResponse;


class ProductForbidenController extends Controller
{
    private InterfaceProductForbidenRepository $interfaceProductForbidenRepository;


    public function __construct(InterfaceProductForbidenRepository $interfaceProductForbidenRepository)
    {
        $this->interfaceProductForbidenRepository = $interfaceProductForbidenRepository;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(ProductForbidenRequest $request): AnonymousResourceCollection
    {
        @$count = $request->count ?? 10;
        @$title = $request->title;
        @$description = $request->description;
        @$status = $request->status;

        $productForbidens = $this->interfaceProductForbidenRepository->query();

        if (@$title)
            $productForbidens = $productForbidens->whereTitle($title);
        if (@$description)
            $productForbidens = $productForbidens->whereDescription($description);
        if (@$status)
            $productForbidens = $productForbidens->whereStatus($status);

        return    ProductForbidenResource::collection($productForbidens->paginate($count));
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
    public function store(StoreProductForbidenRequest $request): JsonResponse
    {
        $data = $request->except(["_token"]);
        if ($this->interfaceProductForbidenRepository->insertData($data))
            return response()->json(['message' => 'successfully your transaction!'], HTTPResponse::HTTP_OK);
        return response()->json(['message' => 'sorry, your transaction fails!'], HTTPResponse::HTTP_BAD_REQUEST);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id): ProductForbidenResource
    {
        return ProductForbidenResource::make($this->interfaceProductForbidenRepository->findById($id));
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
    public function update(UpdateProductForbidenRequest $request, int $id): JsonResponse
    {
        $data = $request->except(["_token"]);
        if ($this->interfaceProductForbidenRepository->updateItem($id, $data))
            return response()->json(['message' => 'successfully your transaction!'], HTTPResponse::HTTP_OK);
        return response()->json(['message' => 'sorry, your transaction fails!'], HTTPResponse::HTTP_BAD_REQUEST);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        if ($this->interfaceProductForbidenRepository->deleteData($id))
            return response()->json(['message' => 'successfully your transaction!'], HTTPResponse::HTTP_OK);
        return response()->json(['message' => 'sorry, your transaction fails!'], HTTPResponse::HTTP_BAD_REQUEST);
    }
}
