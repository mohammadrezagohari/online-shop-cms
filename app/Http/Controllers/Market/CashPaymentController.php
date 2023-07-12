<?php

namespace App\Http\Controllers\Market;

use App\Http\Controllers\Controller;
use App\Http\Requests\cashPayment\CashPaymentRequest;
use App\Http\Requests\cashPayment\StoreCashPaymentRequest;
use App\Http\Requests\cashPayment\UpdateCashPaymentRequest;
use App\Http\Resources\cartItem\CartItemResource;
use App\Http\Resources\cashPayment\CashPaymentResource;
use App\Models\Market\CashPayment;
use App\Repositories\MySQL\CashPaymentRepository\InterfaceCashPaymentRepository;
use http\Client\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use PhpParser\Builder\Interface_;
use Symfony\Component\HttpFoundation\Response as HTTPResponse;

class CashPaymentController extends Controller
{
    private  InterfaceCashPaymentRepository $interfaceCashPaymentRepository;


    public function __construct(InterfaceCashPaymentRepository $interfaceCashPaymentRepository)
    {
        $this->interfaceCashPaymentRepository=$interfaceCashPaymentRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(CashPaymentRequest $request):AnonymousResourceCollection
    {
        $count=@$request->count ?? 10 ;
        $user_id=@$request->user_id ;
        $cash_receiver=@$request->cash_receiver ;
        $cashPayments=$this->interfaceCashPaymentRepository->query();

        if($user_id)
            $cashPayments=$cashPayments->whereUserId($user_id);
        if($cash_receiver)
            $cashPayments=$cashPayments->whereCashReceiver($cash_receiver);

        $cashPayments=$cashPayments->paginate($count);
        return CashPaymentResource::collection($cashPayments);
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
    public function store(StoreCashPaymentRequest $request):JsonResponse
    {
        $data=$request->except(['_token']);
        if($this->interfaceCashPaymentRepository->insertData($data))
            return response()->json(['message' => 'successfully your transaction!'], HTTPResponse::HTTP_OK);
        return response()->json(['message' => 'sorry, your transaction fails!'], HTTPResponse::HTTP_BAD_REQUEST);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id):CashPaymentResource
    {
        return CashPaymentResource::make($this->interfaceCashPaymentRepository->findById($id));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CashPayment $cashPayment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCashPaymentRequest $request, int $id):JsonResponse
    {
        $data=$request->except(['_token']);
        if($this->interfaceCashPaymentRepository->updateItem($id,$data))
            return response()->json(['message' => 'successfully your transaction!'], HTTPResponse::HTTP_OK);
        return response()->json(['message' => 'sorry, your transaction fails!'], HTTPResponse::HTTP_BAD_REQUEST);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int  $id):JsonResponse
    {
        if($this->interfaceCashPaymentRepository->deleteData($id))
            return response()->json(['message' => 'successfully your transaction!'], HTTPResponse::HTTP_OK);
        return response()->json(['message' => 'sorry, your transaction fails!'], HTTPResponse::HTTP_BAD_REQUEST);
    }
}
