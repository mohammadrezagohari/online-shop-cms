<?php

namespace App\Http\Controllers\Market;

use App\Http\Controllers\Controller;
use App\Http\Requests\payment\PaymentRequest;
use App\Http\Requests\payment\StorePaymentRequest;
use App\Http\Requests\payment\UpdatePaymentRequest;
use App\Http\Resources\payment\PaymentResource;
use App\Models\Market\CashPayment;
use App\Models\Market\OfflinePayment;
use App\Models\Market\OnlinePayment;
use App\Models\Market\Payment;
use App\Repositories\MySQL\PaymentRepository\InterfacePaymentRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Symfony\Component\HttpFoundation\Response as HTTPResponse;

class PaymentController extends Controller
{
    private InterfacePaymentRepository $interfacePaymentRepository;


    public function __construct(InterfacePaymentRepository $interfacePaymentRepository)
    {
        return $this->interfacePaymentRepository = $interfacePaymentRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(PaymentRequest $request): AnonymousResourceCollection
    {
        $count = @$request->count ?? 10;
        $status = @$request->status;
        $type = @$request->type;
        $payments = $this->interfacePaymentRepository->query();

        if (@$status != null)
            $payments = $payments->whereStatus($status);
        if (@$type)
            $payments = $payments->whereType($type);

        return PaymentResource::collection($payments->paginate($count));

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
    public function store(StorePaymentRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id): PaymentResource
    {
        return PaymentResource::make($this->interfacePaymentRepository->findById($id));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Payment $payment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePaymentRequest $request, Payment $payment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id): JsonResponse
    {
        $result = $this->interfacePaymentRepository->findById($id);
        if ($result->type == 0) {
            OnlinePayment::find($result->paymentable_id)->delete();
            $this->interfacePaymentRepository->deleteData($id);
            return response()->json(['message' => 'successfully your transaction!'], HTTPResponse::HTTP_OK);

        } elseif ($result->type == 1) {
            OfflinePayment::find($result->paymentable_id)->delete();
            $this->interfacePaymentRepository->deleteData($id);
            return response()->json(['message' => 'sorry, your transaction fails!'], HTTPResponse::HTTP_BAD_REQUEST);

        } elseif ($result->type == 2) {
            CashPayment::find($result->paymentable_id)->delete();
            $this->interfacePaymentRepository->deleteData($id);
            return response()->json(['message' => 'sorry, your transaction fails!'], HTTPResponse::HTTP_BAD_REQUEST);

        } else {
            return response()->json(['message' => 'sorry, your transaction fails!'], HTTPResponse::HTTP_BAD_REQUEST);

        }

    }
}
