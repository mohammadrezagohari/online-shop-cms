<?php

namespace App\Http\Controllers\Market;

use App\Http\Controllers\Controller;
use App\Http\Requests\order\OrderRequest;
use App\Http\Requests\order\StoreOrderRequest;
use App\Http\Requests\order\UpdateOrderRequest;
use App\Http\Resources\order\OrderResource;
use App\Models\Market\CartItem;
use App\Models\Market\Order;
use App\Repositories\MySQL\CartItemRepository\InterfaceCartItemRepository;
use App\Repositories\MySQL\OrderItemRepository\InterfaceOrderItemRepository;
use App\Repositories\MySQL\OrderRepository\InterfaceOrderRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Symfony\Component\HttpFoundation\Response as HTTPResponse;

class OrderController extends Controller
{

    private InterfaceOrderRepository $interfaceOrderRepository;
    private InterfaceCartItemRepository $interfaceCartItemRepository;
    private InterfaceOrderItemRepository $interfaceOrderItemRepository;

    /**
     * @param InterfaceOrderRepository $interfaceOrderRepository
     * @param InterfaceCartItemRepository $interfaceCartItemRepository
     */
    public function __construct(InterfaceOrderRepository $interfaceOrderRepository, InterfaceCartItemRepository $interfaceCartItemRepository, InterfaceOrderItemRepository $interfaceOrderItemRepository)
    {

        $this->interfaceOrderRepository = $interfaceOrderRepository;
        $this->interfaceCartItemRepository = $interfaceCartItemRepository;
        $this->interfaceOrderItemRepository = $interfaceOrderItemRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(OrderRequest $request): AnonymousResourceCollection
    {
        $count = @$request->count ?? 10;
        $user_id = @$request->user_id;
        $order_status = @$request->order_status;
        $orders = $this->interfaceOrderRepository->query();
        if (@$user_id)
            $orders = $orders->whereUserId($user_id);
        if (@$order_status != null)
            $orders = $orders->whereOrderStatus($order_status);

        return OrderResource::collection($orders->paginate($count));


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
    public function store(StoreOrderRequest $request): JsonResponse
    {
        $data = $request->except(['_token']);
        $user_id = $request->user_id;

        if ($order = $this->interfaceOrderRepository->insertData($data)) {
            $cartItems = $this->interfaceCartItemRepository->findByUserId($user_id);

            foreach ($cartItems as $cartItem) {
                $cartItem['order_id'] = $order->id;

                $this->interfaceOrderItemRepository->insertData($cartItem);
            }
            $this->interfaceCartItemRepository->deleteCollection($user_id);
            return response()->json(['message' => 'successfully your transaction!'], HTTPResponse::HTTP_OK);

        } else {
            return response()->json(['message' => 'sorry, your transaction fails!'], HTTPResponse::HTTP_BAD_REQUEST);

        }


    }

    /**
     * Display the specified resource.
     */
    public function show(int $id): OrderResource
    {
        return OrderResource::make($this->interfaceOrderRepository->findById($id));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateOrderRequest $request, int $id):JsonResponse
    {

        $data = $request->except(['_token']);
        if ($this->interfaceOrderRepository->updateItem($id, $data))

            return response()->json(['message' => 'successfully your transaction!'], HTTPResponse::HTTP_OK);
        return response()->json(['message' => 'sorry, your transaction fails!'], HTTPResponse::HTTP_BAD_REQUEST);


    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id):JsonResponse
    {
        if($this->interfaceOrderItemRepository->findByOrderIdAndDelete($id)){
            if($this->interfaceOrderRepository->deleteData($id))
                return response()->json(['message' => 'successfully your transaction!'], HTTPResponse::HTTP_OK);
        }
        return response()->json(['message' => 'sorry, your transaction fails!'], HTTPResponse::HTTP_BAD_REQUEST);
    }
}
