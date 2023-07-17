<?php

namespace App\Http\Controllers\Market;

use App\Http\Controllers\Controller;
use App\Http\Requests\transaction\StoreTransactionRequest;
use App\Http\Requests\transaction\TransactionRequest;
use App\Http\Requests\transaction\UpdateTransactionRequest;
use App\Http\Resources\tranaction\TransactionResource;
use App\Models\Market\Transaction;
use App\Repositories\MySQL\TransactionRepository\InterfaceTransactionRepository;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ProductTransactionController extends Controller
{
    private  InterfaceTransactionRepository $interfaceTransactionRepository;

    public  function __construct(InterfaceTransactionRepository $interfaceTransactionRepository)
    {
        $this->interfaceTransactionRepository=$interfaceTransactionRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(TransactionRequest $request):AnonymousResourceCollection
    {
      $count=@$request->count ?? 10;
      $bank=@$request->bank;
      $user_id=@$request->user_id;
      $order_id=@$request->order_id;
      $status=@$request->status;
      $transactions=$this->interfaceTransactionRepository->query();

      if(@$bank)
          $transactions=$transactions->whereBank($bank);
      if(@$status != null)
          $transactions=$transactions->whereStatus($status);

        if(@$user_id)
          $transactions=$transactions->whereUserId($user_id);
      if(@$order_id)
          $transactions=$transactions->whereOrderId($order_id);



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
    public function store(StoreTransactionRequest $request)
    {
        $data=$request->except(['_token']);

      if($this->interfaceTransactionRepository->insertData($data)){



      }

    }

    /**
     * Display the specified resource.
     */
    public function show(Transaction $transaction)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Transaction $transaction)
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
