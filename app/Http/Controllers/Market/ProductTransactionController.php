<?php

namespace App\Http\Controllers\Market;

use App\Http\Controllers\Controller;
use App\Http\Requests\transaction\StoreTransactionRequest;
use App\Http\Requests\transaction\TransactionRequest;
use App\Http\Requests\transaction\UpdateTransactionRequest;
use App\Http\Resources\tranaction\TransactionResource;
use App\Models\User;
use App\Repositories\MySQL\OrderRepository\InterfaceOrderRepository;
use App\Repositories\MySQL\PaymentRepository\InterfacePaymentRepository;
use App\Repositories\MySQL\ProductRepository\InterfaceProductRepository;
use App\Repositories\MySQL\TransactionRepository\InterfaceTransactionRepository;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpFoundation\Response as HTTPResponse;

class ProductTransactionController extends Controller
{
    private InterfaceTransactionRepository $interfaceTransactionRepository;
    private InterfaceOrderRepository $interfaceOrderRepository;
    private InterfacePaymentRepository $interfacePaymentRepository;

    /**
     * @param InterfaceTransactionRepository $interfaceTransactionRepository
     * @param InterfaceOrderRepository $interfaceOrderRepository
     */
    public function __construct(InterfaceTransactionRepository $interfaceTransactionRepository, InterfaceOrderRepository $interfaceOrderRepository, InterfacePaymentRepository $interfacePaymentRepository)
    {
        $this->interfaceTransactionRepository = $interfaceTransactionRepository;
        $this->interfaceOrderRepository = $interfaceOrderRepository;
        $this->interfacePaymentRepository = $interfacePaymentRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(TransactionRequest $request): AnonymousResourceCollection
    {
        $count = @$request->count ?? 10;
        $bank = @$request->bank;
        $user_id = @$request->user_id;
        $order_id = @$request->order_id;
        $status = @$request->status;
        $transactions = $this->interfaceTransactionRepository->query();

        if (@$bank)
            $transactions = $transactions->whereBank($bank);
        if (@$status != null)
            $transactions = $transactions->whereStatus($status);

        if (@$user_id)
            $transactions = $transactions->whereUserId($user_id);
        if (@$order_id)
            $transactions = $transactions->whereOrderId($order_id);


        return TransactionResource::collection($transactions->paginate($count));

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
    public function verify(StoreTransactionRequest $request)
    {
        $token= $request->header('Authorization');
        $data = $request->except(['_token']);
        $user = User::find($data['user_id']);
        $amount = $this->interfaceOrderRepository->findById($data['order_id'])['order_final_amount'];
        $data["amount"] = $amount;
        $this->interfaceTransactionRepository->insertData($data);
        $response = Http::withHeaders([
            'accept: application/json',
            'content-type: application/json'

        ])->post('https://api.zarinpal.com/pg/v4/payment/request.json', [
            "merchant_id" => "1344b5d4-0048-11e8-94db-005056a205be",
            "amount" => $amount,
            "callback_url" => "http://localhost:8000/api/v1/transaction/callback/" . $data['order_id'] ,
            "description" => "خرید محصول توسط کاربر" . $data['user_id'],
            "metadata" => [
                'mobile' => $user->mobile,
                'email' => $user->email
            ]
        ]);
        $result = json_decode($response->body());
        $authority = $result->data->authority;
        return 'https://www.zarinpal.com/pg/StartPay/' . $authority;
    }

    public function callback(Request $request, int $id)
    {
        $order = $this->interfaceOrderRepository->findById($id);
        if ($request['Status'] == "OK") {
            $this->interfaceTransactionRepository->query()->where('order_id', '=', $id)->update(['status' => 1]);
            $this->interfaceOrderRepository->updateItem($id, [
                'payment_status' => 1
            ]);
            $this->interfacePaymentRepository->updateItem($order->payment_id, ['status' => 1]);
            $this->interfacePaymentRepository->getPaymentableWithPaymentId($order->payment_id);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id):TransactionResource
    {
        return TransactionResource::make($this->interfaceTransactionRepository->findById($id));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTransactionRequest $request, int $id)
    {
        $data=$request->all();
        if($this->interfaceTransactionRepository->updateItem($id,$data))
            return response()->json(['message' => 'successfully your transaction!'], HTTPResponse::HTTP_OK);
        return response()->json(['message' => 'sorry, your transaction fails!'], HTTPResponse::HTTP_BAD_REQUEST);
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        //
    }
}
