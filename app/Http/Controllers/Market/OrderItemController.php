<?php

namespace App\Http\Controllers\Market;

use App\Http\Controllers\Controller;
use App\Http\Requests\orderItem\OrderItemRequest;
use App\Http\Requests\orderItem\StoreOrderItemRequest;
use App\Http\Requests\orderItem\UpdateOrderItemRequest;
use App\Http\Resources\orderItem\OrderItemResource;
use App\Models\Market\OrderItem;
use App\Repositories\MySQL\OrderItemRepository\InterfaceOrderItemRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Symfony\Component\HttpFoundation\Response as HTTPResponse;

class OrderItemController extends Controller
{

    private InterfaceOrderItemRepository $interfaceOrderItemRepository;

    public function __construct(InterfaceOrderItemRepository $interfaceOrderItemRepository)
    {

        $this->interfaceOrderItemRepository = $interfaceOrderItemRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(OrderItemRequest $request): AnonymousResourceCollection
    {
        $count = @$request->count ?? 10;
        $order_id = @$request->order_id;
        $product_id = @$request->product_id;
        $color_id = @$request->color_id;
        $guarantee_id = @$request->guarantee_id;
        $orderItems = $this->interfaceOrderItemRepository->query();

        if (@$order_id)
            $orderItems = $orderItems->whereOrderId($order_id);
        if (@$product_id)
            $orderItems = $orderItems->whereProductId($product_id);
        if (@$color_id)
            $orderItems = $orderItems->whereColorId($color_id);
        if (@$guarantee_id)
            $orderItems = $orderItems->whereGuaranteeId($guarantee_id);

        return OrderItemResource::collection($orderItems->paginate($count));

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
    public function store(StoreOrderItemRequest $request)
    {
//        $data = $request->except(['_token']);
//        if ($this->interfaceOrderItemRepository->insertData($data))
//            return response()->json(['message' => 'successfully your transaction!'], HTTPResponse::HTTP_OK);
//        return response()->json(['message' => 'sorry, your transaction fails!'], HTTPResponse::HTTP_BAD_REQUEST);

   }

    /**
     * Display the specified resource.
     */
    public function show(int $id):OrderItemResource
    {
        return OrderItemResource::make($this->interfaceOrderItemRepository->findById($id));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(OrderItem $orderItem)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateOrderItemRequest $request, int $id):JsonResponse
    {
        $data=$request->only('number');
        $record=$this->interfaceOrderItemRepository->findById($id);
        if($this->interfaceOrderItemRepository->updateItem($id,[
            'number'=>$data["number"],
            'final_total_price'=>$data["number"]*$record->final_product_price,
        ])){

            return response()->json(['message' => 'successfully your transaction!'], HTTPResponse::HTTP_OK);
        }


        return response()->json(['message' => 'sorry, your transaction fails!'], HTTPResponse::HTTP_BAD_REQUEST);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id):JsonResponse
    {
        if($this->interfaceOrderItemRepository->deleteData($id))
            return response()->json(['message' => 'successfully your transaction!'], HTTPResponse::HTTP_OK);
        return response()->json(['message' => 'sorry, your transaction fails!'], HTTPResponse::HTTP_BAD_REQUEST);

    }
}
