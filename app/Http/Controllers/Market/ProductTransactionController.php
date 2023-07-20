<?php

namespace App\Http\Controllers\Market;

use App\Http\Controllers\Controller;
use App\Http\Requests\transaction\StoreTransactionRequest;
use App\Http\Requests\transaction\TransactionRequest;
use App\Http\Requests\transaction\UpdateTransactionRequest;
use App\Http\Resources\tranaction\TransactionResource;
use App\Models\Market\Transaction;
use App\Models\User;
use App\Repositories\MySQL\OrderRepository\InterfaceOrderRepository;
use App\Repositories\MySQL\TransactionRepository\InterfaceTransactionRepository;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Http;

class ProductTransactionController extends Controller
{
    private InterfaceTransactionRepository $interfaceTransactionRepository;
    private InterfaceOrderRepository $interfaceOrderRepository;

    /**
     * @param InterfaceTransactionRepository $interfaceTransactionRepository
     * @param InterfaceOrderRepository $interfaceOrderRepository
     */
    public function __construct(InterfaceTransactionRepository $interfaceTransactionRepository, InterfaceOrderRepository $interfaceOrderRepository)
    {
        $this->interfaceTransactionRepository = $interfaceTransactionRepository;
        $this->interfaceOrderRepository = $interfaceOrderRepository;
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
        $data = $request->except(['_token']);
        $user=User::find($data['user_id']);
        $amount = $this->interfaceOrderRepository->findById($data['order_id'])['order_final_amount'];
       $response= Http::withHeaders([
            'accept: application/json',
            'content-type: application/json',
        ])->post('https://api.zarinpal.com/pg/v4/payment/request.json', [
            "merchant_id" => "1344b5d4-0048-11e8-94db-005056a205be",
            "amount" => $amount,
            "callback_url" => "http://localhost:8000/api/v1/transaction/callback",
            "description" =>"خرید محصول توسط کاربر".$data['user_id'],
            "metadata" =>[
                 'mobile'=>$user->mobile,
                  'email'=> $user->email
                       ]
            ]);
             $result= json_decode($response->body());
               $authority= $result->data->authority;
//             Http::get('https://www.zarinpal.com/pg/StartPay/'.$authority);
              return 'https://www.zarinpal.com/pg/StartPay/'.$authority;
    }

    public function callback (Request $request)
    {
    return  $status=$request["status"];
    }

    /**
     * Display the specified resource.
     */
    public function show(Transaction $transaction)
    {
        //
    }



    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTransactionRequest $request, Transaction $transaction)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Transaction $transaction)
    {
        //
    }
}
