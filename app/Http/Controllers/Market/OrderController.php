<?php

namespace App\Http\Controllers\Market;

use App\Enums\PaymentType;
use App\Http\Controllers\Controller;
use App\Http\Requests\order\OrderRequest;
use App\Http\Requests\order\StoreOrderRequest;
use App\Http\Requests\order\UpdateOrderRequest;
use App\Http\Resources\order\OrderResource;
use App\Models\Market\CartItem;
use App\Models\Market\Delivery;
use App\Models\Market\Order;
use App\Models\Market\Product;
use App\Repositories\MySQL\CartItemRepository\InterfaceCartItemRepository;
use App\Repositories\MySQL\CashPaymentRepository\InterfaceCashPaymentRepository;
use App\Repositories\MySQL\DeliveryRepository\InterfaceDeliveryRepository;
use App\Repositories\MySQL\GuaranteeRepository\InterfaceGuaranteeRepository;
use App\Repositories\MySQL\OfflinePaymentRepository\InterfaceOfflinePaymentRepository;
use App\Repositories\MySQL\OnlinePaymentRepository\InterfaceOnlinePaymentRepository;
use App\Repositories\MySQL\OrderItemRepository\InterfaceOrderItemRepository;
use App\Repositories\MySQL\OrderRepository\InterfaceOrderRepository;
use App\Repositories\MySQL\PaymentRepository\InterfacePaymentRepository;
use App\Repositories\MySQL\ProductColorRepository\InterfaceProductColorRepository;
use App\Repositories\MySQL\ProductRepository\InterfaceProductRepository;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Symfony\Component\HttpFoundation\Response as HTTPResponse;
use function App\final_product_price;
use function App\final_total_price;

class OrderController extends Controller
{

    private InterfaceOrderRepository $interfaceOrderRepository;
    private InterfaceCartItemRepository $interfaceCartItemRepository;
    private InterfaceOrderItemRepository $interfaceOrderItemRepository;
    private InterfaceDeliveryRepository $interfaceDeliveryRepository;
    private InterfaceProductRepository $interfaceProductRepository;
    private InterfaceProductColorRepository $interfaceProductColorRepository;
    private InterfaceGuaranteeRepository $interfaceGuaranteeRepository;
    private InterfacePaymentRepository $interfacePaymentRepository;
    private InterfaceOnlinePaymentRepository $interfaceOnlinePaymentRepository;
    private InterfaceOfflinePaymentRepository $interfaceOfflinePaymentRepository;
    private InterfaceCashPaymentRepository $interfaceCashPaymentRepository;


    public function __construct(InterfaceOrderRepository          $interfaceOrderRepository,
                                InterfaceCartItemRepository       $interfaceCartItemRepository,
                                InterfaceOrderItemRepository      $interfaceOrderItemRepository,
                                InterfaceDeliveryRepository       $interfaceDeliveryRepository,
                                InterfaceProductRepository        $interfaceProductRepository,
                                InterfaceProductColorRepository   $interfaceProductColorRepository,
                                InterfaceGuaranteeRepository      $interfaceGuaranteeRepository,
                                InterfacePaymentRepository        $interfacePaymentRepository,
                                InterfaceOnlinePaymentRepository  $interfaceOnlinePaymentRepository,
                                InterfaceOfflinePaymentRepository $interfaceOfflinePaymentRepository,
                                InterfaceCashPaymentRepository    $interfaceCashPaymentRepository,


    )
    {

        $this->interfaceOrderRepository = $interfaceOrderRepository;
        $this->interfaceCartItemRepository = $interfaceCartItemRepository;
        $this->interfaceOrderItemRepository = $interfaceOrderItemRepository;
        $this->interfaceDeliveryRepository = $interfaceDeliveryRepository;
        $this->interfaceProductRepository = $interfaceProductRepository;
        $this->interfaceProductColorRepository = $interfaceProductColorRepository;
        $this->interfaceGuaranteeRepository = $interfaceGuaranteeRepository;
        $this->interfacePaymentRepository = $interfacePaymentRepository;
        $this->interfaceOnlinePaymentRepository = $interfaceOnlinePaymentRepository;
        $this->interfaceOfflinePaymentRepository = $interfaceOfflinePaymentRepository;
        $this->interfaceCashPaymentRepository = $interfaceCashPaymentRepository;
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
        $delivery = $this->interfaceDeliveryRepository->findById($data["delivery_id"]);
        $data["delivery_amount"] = $delivery["amount"];
        $data["delivery_date"] = Carbon::now()->addDay($delivery->delivery_time);

        if ($this->interfaceCartItemRepository->query()->count() > 0) {

            if ($order = $this->interfaceOrderRepository->insertData($data)) {
                $cartItems = $this->interfaceCartItemRepository->findByUserId($user_id);
                $final_total_price = 0;
                foreach ($cartItems as $cartItem) {
                    $products[] = $cartItem['product_id'];
                    $cartItem['order_id'] = $order->id;
                    $product = $this->interfaceProductRepository->findById($cartItem["product_id"]);
                    $color = $this->interfaceProductColorRepository->findById($cartItem["color_id"]);
                    $guarantee = $this->interfaceGuaranteeRepository->findById($cartItem["guarantee_id"]);
                    $cartItem['final_product_price'] = final_product_price($product["price"], $color["price_increase"], $guarantee["price_increase"]);
                    $cartItem['final_total_price'] = final_total_price($cartItem["number"], $cartItem['final_product_price']);
                    $final_total_price += $cartItem['final_total_price'];
                    $this->interfaceOrderItemRepository->insertData($cartItem);
                }
                $this->interfaceOrderRepository->updateItem($order->id, [
                    'order_final_amount' => $final_total_price + $order->delivery_amount,
                ]);
                $paymentType = null;
                switch ($data['payment_type']) {
                    case 0;
                        $paymentType = PaymentType::OnlinePayment;
                        $paymentId = $this->interfaceOnlinePaymentRepository->insertData([
                            'amount' => $final_total_price + $order->delivery_amount,
                            'user_id' => $data["user_id"],
                        ])["id"];
                        break;
                    case 1:
                        $paymentType = PaymentType::OfflinePayment;

                        $paymentId = $this->interfaceOfflinePaymentRepository->insertData([
                            'amount' => $final_total_price + $order->delivery_amount,
                            'user_id' => $data["user_id"],
                        ])["id"];
                        break;
                    case 2:
                        $paymentType = PaymentType::CashPayment;
                        $paymentId = $this->interfaceCashPaymentRepository->insertData([
                            'amount' => $final_total_price + $order->delivery_amount,
                            'user_id' => $data["user_id"],
                        ])["id"];
                        break;

                }
                $this->interfacePaymentRepository->insertData([
                    'amount' => $final_total_price,
                    'user_id' => $data["user_id"],
                    'type' => $data['payment_type'],
                    'paymentable_id' => $paymentId,
                    'paymentable_type' => $paymentType,
                ]);

                $this->interfaceCartItemRepository->deleteCollection($user_id);

                return response()->json(['message' => 'successfully your transaction!'], HTTPResponse::HTTP_OK);

            } else {
                return response()->json(['message' => 'sorry, your transaction fails!'], HTTPResponse::HTTP_BAD_REQUEST);
            }

        }
        return response()->json(['message' => 'sorry, your transaction fails because cart-items empty!'], HTTPResponse::HTTP_BAD_REQUEST);

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
    public function update(UpdateOrderRequest $request, int $id)
    {
        $data = $request->only(['address_id', 'payment_type', 'delivery_id']);
        $order = $this->interfaceOrderRepository->findById($id);
        if ($order->address_id != $data["address_id"]) {
            $this->interfaceOrderRepository->updateItem($id, [
                'address_id' => $data["address_id"]
            ]);
            return response()->json(['message' => 'successfully your transaction!'], HTTPResponse::HTTP_OK);

        }

        if ($order->deliver_id != $data['delivery_id']) {
            $delivery_amount = $this->interfaceDeliveryRepository->findById($data['delivery_id'])['amount'];
            $delivery_time = $this->interfaceDeliveryRepository->findById($data['delivery_id'])['delivery_time'];
            $orderItems_final_amount = $this->interfaceOrderItemRepository->getSumFinalTotalPriceOrderItemsByOrderId($order->id);
            $this->interfaceOrderRepository->updateItem($id,
                [
                    'delivery_id' => $data['delivery_id'],
                    'delivery_amount' => $delivery_amount,
                    'delivery_date' => Carbon::now()->addDay($delivery_time),
                    'order_final_amount' => $orderItems_final_amount + $delivery_amount
                ]);
            return response()->json(['message' => 'successfully your transaction!'], HTTPResponse::HTTP_OK);

        }

        if ($order->payment_type != $data['payment_type']) {
            $order = $this->interfaceOrderRepository->findById($id);
            switch ($data['payment_type']) {
                case 0:

                    $onlinePayment = $this->interfaceOnlinePaymentRepository->insertData([
                        'amount' => $order->order_final_amount,
                        'user_id' => $order->user_id,
                    ]);

                    $payment = $this->interfacePaymentRepository->insertData([
                        'amount' => $order->order_final_amount,
                        'user_id' => $order->user_id,
                        'type' => $data['payment_type'],
                        'paymentable_id' => $onlinePayment->id,
                        'paymentable_type' => PaymentType::OnlinePayment,
                    ]);

                    $this->interfaceOrderRepository->updateItem($id, [
                        'payment_id' => $payment->id,
                        'payment_type' => $data['payment_type']
                    ]);
                    return response()->json(['message' => 'successfully your transaction!'], HTTPResponse::HTTP_OK);
                case 1:
                    $offlinePayment = $this->interfaceOfflinePaymentRepository->insertData([
                        'amount' => $order->order_final_amount,
                        'user_id' => $order->user_id,
                    ]);
                    $payment = $this->interfacePaymentRepository->insertData([
                        'amount' => $order->order_final_amount,
                        'user_id' => $order->user_id,
                        'type' => $data['payment_type'],
                        'paymentable_id' => $offlinePayment->id,
                        'paymentable_type' => PaymentType::OfflinePayment,
                    ]);
                    $this->interfaceOrderRepository->updateItem($id, [
                        'payment_id' => $payment->id,
                        'payment_type' => $data['payment_type']
                    ]);
                    return response()->json(['message' => 'successfully your transaction!'], HTTPResponse::HTTP_OK);
                case  2:
                    $cashPayment = $this->interfaceCashPaymentRepository->insertData([
                        'amount' => $order->order_final_amount,
                        'user_id' => $order->user_id,
                    ]);
                    $payment = $this->interfacePaymentRepository->insertData([
                        'amount' => $order->order_final_amount,
                        'user_id' => $order->user_id,
                        'type' => $data['payment_type'],
                        'paymentable_id' => $cashPayment->id,
                        'paymentable_type' => PaymentType::CashPayment,
                    ]);
                    $this->interfaceOrderRepository->updateItem($id, [
                        'payment_id' => $payment->id,
                        'payment_type' => $data['payment_type']
                    ]);
                    return response()->json(['message' => 'successfully your transaction!'], HTTPResponse::HTTP_OK);
            }
        }

        return response()->json(['message' => 'sorry, your transaction fails because cart-items empty!'], HTTPResponse::HTTP_BAD_REQUEST);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id): JsonResponse
    {
        if ($this->interfaceOrderItemRepository->findByOrderIdAndDelete($id)) {
            if ($this->interfaceOrderRepository->deleteData($id))
                return response()->json(['message' => 'successfully your transaction!'], HTTPResponse::HTTP_OK);
        }
        return response()->json(['message' => 'sorry, your transaction fails!'], HTTPResponse::HTTP_BAD_REQUEST);
    }
}
