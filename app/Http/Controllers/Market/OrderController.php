<?php

namespace App\Http\Controllers\Market;

use App\Enums\PaymentType;
use App\Http\Controllers\Controller;
use App\Http\Requests\order\OrderRequest;
use App\Http\Requests\order\StoreOrderRequest;
use App\Http\Requests\order\UpdateOrderRequest;
use App\Http\Resources\order\OrderResource;
use App\Models\Market\Order;
use App\Repositories\MySQL\AmazingSaleRepository\InterfaceAmazingSaleRepository;
use App\Repositories\MySQL\CartItemRepository\InterfaceCartItemRepository;
use App\Repositories\MySQL\CashPaymentRepository\InterfaceCashPaymentRepository;
use App\Repositories\MySQL\CopanRepository\InterfaceCopanRepository;
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
use function App\check_code_of_copan;
use function App\final_product_price;
use function App\final_product_price_with_amazing_sale;
use function App\final_product_price_without_amazing_sale;
use function App\final_total_price;
use function App\final_total_price_with_amazing_sale;
use function App\final_total_price_without_amazing_sale;

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
    private InterfaceCopanRepository $interfaceCopanRepository;
    private InterfaceAmazingSaleRepository $interfaceAmazingSaleRepository;


    /**
     * @param InterfaceOrderRepository $interfaceOrderRepository
     * @param InterfaceCartItemRepository $interfaceCartItemRepository
     * @param InterfaceOrderItemRepository $interfaceOrderItemRepository
     * @param InterfaceDeliveryRepository $interfaceDeliveryRepository
     * @param InterfaceProductRepository $interfaceProductRepository
     * @param InterfaceProductColorRepository $interfaceProductColorRepository
     * @param InterfaceGuaranteeRepository $interfaceGuaranteeRepository
     * @param InterfacePaymentRepository $interfacePaymentRepository
     * @param InterfaceOnlinePaymentRepository $interfaceOnlinePaymentRepository
     * @param InterfaceOfflinePaymentRepository $interfaceOfflinePaymentRepository
     * @param InterfaceCashPaymentRepository $interfaceCashPaymentRepository
     * @param InterfaceCopanRepository $interfaceCopanRepository
     * @param InterfaceAmazingSaleRepository $interfaceAmazingSaleRepository
     */
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
                                InterfaceCopanRepository          $interfaceCopanRepository,
                                InterfaceAmazingSaleRepository    $interfaceAmazingSaleRepository,


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
        $this->interfaceCopanRepository = $interfaceCopanRepository;
        $this->interfaceAmazingSaleRepository = $interfaceAmazingSaleRepository;
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
    public function store(StoreOrderRequest $request)
    {
        $data = @$request->except(['_token']);
        $copan_amount = null;
        $copan_amount_type = null;
        if (@$data["code"]) {
            switch ($this->check_code($data["code"], $data["user_id"])) {
                case 0:
                    return response()->json(['message' => 'sorry,The code not exists!'], HTTPResponse::HTTP_BAD_REQUEST);
                case  1:
                    return response()->json(['message' => 'sorry,This code expired!'], HTTPResponse::HTTP_BAD_REQUEST);
                case 2:
                    return response()->json(['message' => 'sorry,The number of uses of the sent code is greater than the limit!'], HTTPResponse::HTTP_BAD_REQUEST);

                case 3:
                    return response()->json(['message' => 'sorry,The code sent is not for use by this user!'], HTTPResponse::HTTP_BAD_REQUEST);
                case 4:
                    $copan = $this->interfaceCopanRepository->query()->where('code', '=', $data["code"])->first();
                    $copan_amount = $copan->amount;
                    $copan_amount_type = $copan->amount_type;
                    break;
            }
        }


        $delivery = $this->interfaceDeliveryRepository->findById($data["delivery_id"]);
        $data["delivery_amount"] = $delivery["amount"];
        $data["delivery_date"] = Carbon::now()->addDay($delivery->delivery_time);

        if ($this->interfaceCartItemRepository->findByUserId($data["user_id"])) {
            if ($order = $this->interfaceOrderRepository->insertData($data)) {
                $cartItems = $this->interfaceCartItemRepository->findByUserId($data["user_id"]);
                $final_total_price = 0;
                foreach ($cartItems as $cartItem) {
                    $cartItem['order_id'] = $order->id;
                    $product = $this->interfaceProductRepository->findById($cartItem["product_id"]);
                    $color = $this->interfaceProductColorRepository->findById($cartItem["color_id"]);
                    $guarantee = $this->interfaceGuaranteeRepository->findById($cartItem["guarantee_id"]);
                    $cartItem['final_product_price_without_amazing_sale'] = final_product_price_without_amazing_sale($product["price"], $color["price_increase"], $guarantee["price_increase"]);
                    $cartItem['final_total_price_without_amazing_sale'] = final_total_price_without_amazing_sale($cartItem["number"], $cartItem['final_product_price_without_amazing_sale']);

                    if ($amazing_sale = $this->interfaceAmazingSaleRepository->amazingSaleWithProductIdAndActive($product->id)) {

                        $cartItem['final_product_price_with_amazing_sale'] = final_product_price_with_amazing_sale($product["price"], $amazing_sale->percentage, $color["price_increase"], $guarantee["price_increase"]);
                        $cartItem['final_total_price_with_amazing_sale'] = final_total_price_with_amazing_sale($cartItem["number"], $cartItem["final_product_price_with_amazing_sale"]);
                        $cartItem["amazing_sale_id"] = $amazing_sale->id;

                    } else {

                        $cartItem['final_product_price_with_amazing_sale'] = $cartItem['final_product_price_without_amazing_sale'];
                        $cartItem['final_total_price_with_amazing_sale'] = $cartItem['final_total_price_without_amazing_sale'];
                    }
                    $final_total_price += $cartItem['final_total_price_with_amazing_sale'];


                    $this->interfaceOrderItemRepository->insertData($cartItem);


                }
                if ($copan_amount_type == 0) {
                    $this->interfaceOrderRepository->updateItem($order->id, [
                        'order_final_amount' => $final_total_price + $order->delivery_amount,
                        'order_final_amount_with_copan_discount' => $final_total_price * (1 - $copan_amount / 100) + $order->delivery_amount,
                    ]);
                } elseif ($copan_amount_type == 1) {
                    $this->interfaceOrderRepository->updateItem($order->id, [
                        'order_final_amount' => $final_total_price + $order->delivery_amount,
                        'order_final_amount_with_copan_discount' => ($final_total_price - $copan_amount) + $order->delivery_amount,
                    ]);
                } else {
                    $this->interfaceOrderRepository->updateItem($order->id, [
                        'order_final_amount' => $final_total_price + $order->delivery_amount,
                        'order_final_amount_with_copan_discount' => $final_total_price + $order->delivery_amount,
                    ]);
                }


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

                $this->interfaceCartItemRepository->deleteCollection($data["user_id"]);

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

        if ($order->delivery_id != $data['delivery_id']) {
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


    public function check_code($code, $userId)
    {
        if ($this->interfaceCopanRepository->query()->where('code', '=', $code)->count() > 0) {

            if ($this->interfaceCopanRepository->query()->where('code', '=', $code)->where('start_date', '<', Carbon::now())->where('end_date', '>', Carbon::now())->where('status', '=', 1)->first()) {

                $copanCode = $this->interfaceCopanRepository->query()->where('code', '=', $code)->first();

                if ($copanCode["type"] == 1) {
                    if ($copanCode["user_id"] != $userId)
                        return 3;//
                    return 4; //

                } else {
                    if ($copanCode["number_of_use_code"] >= $copanCode["max_use_code"])
                        return 2;//
                    return 4; //ok

                }
            } else {
                return 1;//

            }
        } else {
            return 0;//

        }
    }
}
