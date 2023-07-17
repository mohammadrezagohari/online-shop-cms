<?php

namespace App\Http\Controllers\Market;

use App\Enums\PaymentType;
use App\Http\Controllers\Controller;
use App\Http\Requests\offlinePayment\OfflinePaymentRequest;
use App\Http\Requests\offlinePayment\StoreOfflinePaymentRequest;
use App\Http\Requests\offlinePayment\UpdateOfflinePaymentRequest;
use App\Http\Resources\offlinePayment\OfflinePaymentResource;
use App\Models\Market\OfflinePayment;
use App\Models\Market\Payment;
use App\Repositories\MySQL\OfflinePaymentRepository\InterfaceOfflinePaymentRepository;
use App\Repositories\MySQL\PaymentRepository\InterfacePaymentRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Symfony\Component\HttpFoundation\Response as HTTPResponse;

class OfflinePaymentController extends Controller
{
    private InterfaceOfflinePaymentRepository $interfaceOfflinePaymentRepository;
    private InterfacePaymentRepository $interfacePaymentRepository;


    public function __construct(InterfaceOfflinePaymentRepository $interfaceOfflinePaymentRepository, InterfacePaymentRepository $interfacePaymentRepository)
    {
        $this->interfaceOfflinePaymentRepository = $interfaceOfflinePaymentRepository;
        $this->interfacePaymentRepository = $interfacePaymentRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(OfflinePaymentRequest $request): AnonymousResourceCollection
    {
        $count = @$request->count ?? 10;
        $user_id = @$request->user_id;
        $status = @$request->status;
        $offlinePayments = $this->interfaceOfflinePaymentRepository->query();

        if (@$user_id)

            $offlinePayments = $offlinePayments->whereUserId($user_id);
        if (@$status != null)
            $offlinePayments = $offlinePayments->whereStatus($status);
        $offlinePayments = $offlinePayments->paginate($count);

        return OfflinePaymentResource::collection($offlinePayments);
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
    public function store(StoreOfflinePaymentRequest $request): JsonResponse
    {
        $data = $request->except(['_token']);
        if ($result = $this->interfaceOfflinePaymentRepository->insertData($data)) {
            $this->interfacePaymentRepository->insertData([
                'amount' => $data['amount'],
                'user_id' => $data['user_id'],
                'status' => 1,
                'type' => 1,
                'paymentable_id' => $result->id,
                'paymentable_type' => PaymentType::OfflinePayment,

            ]);
            return response()->json(['message' => 'successfully your transaction!'], HTTPResponse::HTTP_OK);

        }
        return response()->json(['message' => 'sorry, your transaction fails!'], HTTPResponse::HTTP_BAD_REQUEST);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id): OfflinePaymentResource
    {
        return OfflinePaymentResource::make($this->interfaceOfflinePaymentRepository->findById($id));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(OfflinePayment $offlinePayment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateOfflinePaymentRequest $request, int $id):JsonResponse
    {
        $data = $request->except(['_token']);
        if ($this->interfaceOfflinePaymentRepository->updateItem($id, $data)) {
            $id = $this->interfaceOfflinePaymentRepository->findById($id)->payments[0]["id"];
            $this->interfacePaymentRepository->updateItem($id,$data);
            return response()->json(['message' => 'successfully your transaction!'], HTTPResponse::HTTP_OK);
        }
        return response()->json(['message' => 'sorry, your transaction fails!'], HTTPResponse::HTTP_BAD_REQUEST);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        $payment_id=$this->interfaceOfflinePaymentRepository->findById($id)->payments[0]['id'];


        if ($this->interfaceOfflinePaymentRepository->deleteData($id))
        {
            $this->interfacePaymentRepository->deleteData($payment_id);

            return response()->json(['message' => 'successfully your transaction!'], HTTPResponse::HTTP_OK);

        }
        return response()->json(['message' => 'sorry, your transaction fails!'], HTTPResponse::HTTP_BAD_REQUEST);
    }
}
