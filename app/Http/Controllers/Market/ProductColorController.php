<?php

namespace App\Http\Controllers\Market;

use App\Http\Controllers\Controller;
use App\Http\Requests\product\ProductRequest;
use App\Http\Requests\productColor\ProductColorRequest;
use App\Http\Requests\productImage\ProductImageRequest;
use App\Http\Requests\productColor\StoreProductColorRequest;
use App\Http\Requests\productColor\UpdateProductColorRequest;
use App\Http\Resources\productColor\ProductColorResource;
use App\Models\Market\ProductColor;
use App\Repositories\MySQL\ProductColorRepository\InterfaceProductColorRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Symfony\Component\HttpFoundation\Response as HTTPResponse;
/**
 * @group ProductColor
 *
 *API endpoints for ProductColor Services
 *
 *
 */
class ProductColorController extends Controller
{

    private InterfaceProductColorRepository $interfaceProductColorRepository;


    public function __construct(InterfaceProductColorRepository $interfaceProductColorRepository)
    {
        $this->interfaceProductColorRepository=$interfaceProductColorRepository;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(ProductColorRequest $request):AnonymousResourceCollection
    {
       $count=@$request->count ?? 10;
       $product_id=@$request->product_id;
       $status=@$request->status;
       $productColors=$this->interfaceProductColorRepository->query();

       if(@$product_id)
           $productColors=$productColors->whereProductId($product_id);
       if(@$status != null)
           $productColors=$productColors->whereStatus($status);

       return ProductColorResource::collection($productColors->paginate($count)) ;

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
    public function store(StoreProductColorRequest $request):JsonResponse
    {
        $data=$request->except(['_token']);
       if($this->interfaceProductColorRepository->insertData($data))
           return response()->json(['message' => 'successfully your transaction!'], HTTPResponse::HTTP_OK);
        return response()->json(['message' => 'sorry, your transaction fails!'], HTTPResponse::HTTP_BAD_REQUEST);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id):ProductColorResource
    {
        return ProductColorResource::make($this->interfaceProductColorRepository->findById($id));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ProductColor $productColor)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductColorRequest $request, int $id)
    {

        $data=$request->except(['_token']);
        if($this->interfaceProductColorRepository->updateItem($id,$data))
            return response()->json(['message' => 'successfully your transaction!'], HTTPResponse::HTTP_OK);
        return response()->json(['message' => 'sorry, your transaction fails!'], HTTPResponse::HTTP_BAD_REQUEST);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        if($this->interfaceProductColorRepository->deleteData($id))
            return response()->json(['message' => 'successfully your transaction!'], HTTPResponse::HTTP_OK);
        return response()->json(['message' => 'sorry, your transaction fails!'], HTTPResponse::HTTP_BAD_REQUEST);
    }
}
