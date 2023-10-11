<?php

namespace App\Http\Controllers\Market;

use App\Http\Controllers\Controller;
use App\Http\Requests\product\UpdateProductRequest;
use App\Http\Requests\productRate\ProductRateRequest;
use App\Http\Requests\productRate\StoreProductRateRequest;
use App\Http\Requests\productRate\UpdateProductRateRequest;
use App\Http\Resources\productRate\ProductRateResource;
use App\Repositories\MySQL\ProductRateRepository\InterfaceProductRateRepository;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response as HTTPResponse;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ProductRateController extends Controller
{
    private InterfaceProductRateRepository $interfaceProductRateRepository;

    public function __construct(InterfaceProductRateRepository $interfaceProductRateRepository)
    {
        $this->interfaceProductRateRepository = $interfaceProductRateRepository;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(ProductRateRequest $request):AnonymousResourceCollection
    {
        $count = @$request->count ?? 10;
        $product_category_question_id = @$request->product_category_question_id;
        $rate = @$request->rate;
        $product_id = @$request->product_id;
        $user_id = @$request->user_id;
        $comment = @$request->comment;
        $status = @$request->status;


        $producRates = $this->interfaceProductRateRepository->query();
        if (@$product_category_question_id)
            $producRates = $producRates->whereProductCategoryQuestionId($product_category_question_id);
        if (@$rate)
            $producRates = $producRates->whereRate($rate);
        if (@$product_id)
            $producRates = $producRates->whereProductId($product_id);
        if (@$user_id)
            $producRates = $producRates->whereUserId($user_id);
        if (@$comment)
            $producRates = $producRates->whereComment($comment);
        if (@$status != null)
            $producRates = $producRates->whereStatus($status);

        return ProductRateResource::collection($producRates->paginate($count));
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
    public function store(StoreProductRateRequest $request):JsonResponse
    {
        $data = $request->except(["_token"]);
        if ($this->interfaceProductRateRepository->insertData($data))
            return response()->json(['message' => 'successfully your transaction!'], HTTPResponse::HTTP_OK);
        return response()->json(['message' => 'sorry, your transaction fails!'], HTTPResponse::HTTP_BAD_REQUEST);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id):ProductRateResource
    {
        return ProductRateResource::make($this->interfaceProductRateRepository->findById($id));
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
    public function update(UpdateProductRateRequest $request, int $id):JsonResponse
    {
        $data = $request->except(["_token"]);
        if ($this->interfaceProductRateRepository->updateItem($id, $data))
            return response()->json(['message' => 'successfully your transaction!'], HTTPResponse::HTTP_OK);
        return response()->json(['message' => 'sorry, your transaction fails!'], HTTPResponse::HTTP_BAD_REQUEST);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id):JsonResponse
    {
        if ($this->interfaceProductRateRepository->deleteData($id))
            return response()->json(['message' => 'successfully your transaction!'], HTTPResponse::HTTP_OK);
        return response()->json(['message' => 'sorry, your transaction fails!'], HTTPResponse::HTTP_BAD_REQUEST);
    }
}
