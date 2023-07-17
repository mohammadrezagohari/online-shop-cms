<?php

namespace App\Http\Controllers\Market;

use App\Http\Controllers\Controller;
use App\Http\Requests\productProperty\ProductPropertyRequest;
use App\Http\Requests\productProperty\StoreProductPropertyRequest;
use App\Http\Requests\productProperty\UpdateProductPropertyRequest;
use App\Http\Resources\productProperty\ProductPropertyResource;
use App\Models\Market\ProductProperty;
use App\Repositories\MySQL\ProductPropertyRepository\InterfaceProductPropertyRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Symfony\Component\HttpFoundation\Response as HTTPResponse;

class ProductPropertyController extends Controller
{
    private InterfaceProductPropertyRepository $interfaceProductPropertyRepository;


    public function __construct(InterfaceProductPropertyRepository $interfaceProductPropertyRepository)
    {
        $this->interfaceProductPropertyRepository = $interfaceProductPropertyRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(ProductPropertyRequest $request): AnonymousResourceCollection
    {
        $count = @$request->count ?? 10;
        $product_id = @$request->product_id;
        $productProperties = $this->interfaceProductPropertyRepository->query();

        if (@$product_id)
            $productProperties = $productProperties->whereProductId($product_id);

        return ProductPropertyResource::collection($productProperties->paginate($count));


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
    public function store(StoreProductPropertyRequest $request)
    {
        $data=$request->except(['_token']);
        if($this->interfaceProductPropertyRepository->insertData($data))
           return response()->json(['message' => 'successfully your transaction!'], HTTPResponse::HTTP_OK);
        return response()->json(['message' => 'sorry, your transaction fails!'], HTTPResponse::HTTP_BAD_REQUEST);
    }


    /**
     * Display the specified resource.
     */
    public function show(int $id): ProductPropertyResource
    {
        return ProductPropertyResource::make($this->interfaceProductPropertyRepository->findById($id));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ProductProperty $productProperty)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductPropertyRequest $request, int $id): JsonResponse
    {
        $data = @$request->except(['_token']);
        if ($this->interfaceProductPropertyRepository->updateItem($id, $data))
            return response()->json(['message' => 'successfully your transaction!'], HTTPResponse::HTTP_OK);
        return response()->json(['message' => 'sorry, your transaction fails!'], HTTPResponse::HTTP_BAD_REQUEST);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id): JsonResponse
    {
        if ($this->interfaceProductPropertyRepository->deleteData($id))
            return response()->json(['message' => 'successfully your transaction!'], HTTPResponse::HTTP_OK);
        return response()->json(['message' => 'sorry, your transaction fails!'], HTTPResponse::HTTP_BAD_REQUEST);
    }
}
