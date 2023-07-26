<?php

namespace App\Http\Controllers\Market;

use App\Enums\PaymentType;
use App\Http\Controllers\Controller;
use App\Http\Requests\payment\PaymentRequest;
use App\Http\Requests\payment\StorePaymentRequest;
use App\Http\Requests\payment\UpdatePaymentRequest;
use App\Http\Resources\payment\PaymentResource;
use App\Models\Market\Payment;
use App\Repositories\MySQL\CashPaymentRepository\InterfaceCashPaymentRepository;
use App\Repositories\MySQL\OfflinePaymentRepository\InterfaceOfflinePaymentRepository;
use App\Repositories\MySQL\OnlinePaymentRepository\InterfaceOnlinePaymentRepository;
use App\Repositories\MySQL\PaymentRepository\InterfacePaymentRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Symfony\Component\HttpFoundation\Response as HTTPResponse;

class PaymentController extends Controller
{
    private InterfacePaymentRepository $interfacePaymentRepository;
    private InterfaceOnlinePaymentRepository $interfaceOnlinePaymentRepository;
    private InterfaceOfflinePaymentRepository $interfaceOfflinePaymentRepository;
    private InterfaceCashPaymentRepository $interfaceCashPaymentRepository;


    public function __construct(InterfacePaymentRepository $interfacePaymentRepository, InterfaceOnlinePaymentRepository $interfaceOnlinePaymentRepository, InterfaceOfflinePaymentRepository $interfaceOfflinePaymentRepository, InterfaceCashPaymentRepository $interfaceCashPaymentRepository)
    {
        $this->interfacePaymentRepository = $interfacePaymentRepository;
        $this->interfaceOnlinePaymentRepository = $interfaceOnlinePaymentRepository;
        $this->interfaceOfflinePaymentRepository = $interfaceOfflinePaymentRepository;
        $this->interfaceCashPaymentRepository = $interfaceCashPaymentRepository;
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
        $data = $request->except(['_token']);
        switch ($data['type']) {
            case 0 :
                //Online
                if ($result = $this->interfaceOnlinePaymentRepository->insertData([
                    'amount' => $data['amount'],
                    'user_id' => $data['user_id'],
                    'gateway' => $data['gateway'],
                ])) {
                    $data['paymentable_id'] = $result->id;
                    $data['paymentable_type'] = PaymentType::OnlinePayment;
                    $this->interfacePaymentRepository->insertData($data);
                    return response()->json(['message' => 'successfully your transaction!'], HTTPResponse::HTTP_OK);
                }
                return response()->json(['message' => 'sorry, your transaction fails!'], HTTPResponse::HTTP_BAD_REQUEST);

                break;
            case 1 :
                //offline
                if ($result = $this->interfaceOfflinePaymentRepository->insertData([
                    'amount' => $data['amount'],
                    'user_id' => $data['user_id'],
                ])) {
                    $data['paymentable_id'] = $result->id;
                    $data['paymentable_type'] = PaymentType::OfflinePayment;
                    $this->interfacePaymentRepository->insertData($data);
                    return response()->json(['message' => 'successfully your transaction!'], HTTPResponse::HTTP_OK);
                }
                return response()->json(['message' => 'sorry, your transaction fails!'], HTTPResponse::HTTP_BAD_REQUEST);

                break;
            case 2 :
                //cash
                if ($result = $this->interfaceCashPaymentRepository->insertData([
                    'amount' => $data['amount'],
                    'user_id' => $data['user_id'],
                ])) {
                    $data['paymentable_id'] = $result->id;
                    $data['paymentable_type'] = PaymentType::CashPayment;
                    $this->interfacePaymentRepository->insertData($data);
                    return response()->json(['message' => 'successfully your transaction!'], HTTPResponse::HTTP_OK);
                }
                return response()->json(['message' => 'sorry, your transaction fails!'], HTTPResponse::HTTP_BAD_REQUEST);

                break;
            default:

                return response()->json(['message' => 'sorry, your transaction fails!'], HTTPResponse::HTTP_BAD_REQUEST);

        }

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
    public function update(UpdatePaymentRequest $request, int $id)
    {
        $data = $request->only(['amount', 'user_id', 'status']);

        if ($result = $this->interfacePaymentRepository->findById($id)) {

            if ($this->interfacePaymentRepository->updateItem($id, $data)) {
                switch ($result['type']) {
                    case 0:
                        //onlinePayment

                        if ($this->interfaceOnlinePaymentRepository->updateItem($result->paymentable_id, $data))
                            return response()->json(['message' => 'successfully your transaction!'], HTTPResponse::HTTP_OK);
                        return response()->json(['message' => 'sorry, your transaction fails!'], HTTPResponse::HTTP_BAD_REQUEST);

                    case 1:
                        //offlinePayment
                        if ($this->interfaceOfflinePaymentRepository->updateItem($result->paymentable_id, $data))
                            return response()->json(['message' => 'successfully your transaction!'], HTTPResponse::HTTP_OK);
                        return response()->json(['message' => 'sorry, your transaction fails!'], HTTPResponse::HTTP_BAD_REQUEST);

                    case 2:
                        //cashPayment
                        if ($this->interfaceCashPaymentRepository->updateItem($result->paymentable_id, $data))
                            return response()->json(['message' => 'successfully your transaction!'], HTTPResponse::HTTP_OK);
                        return response()->json(['message' => 'sorry, your transaction fails!'], HTTPResponse::HTTP_BAD_REQUEST);

                }
            }
            return response()->json(['message' => 'sorry, your transaction fails!'], HTTPResponse::HTTP_BAD_REQUEST);
        }
        return response()->json(['message' => 'sorry, your transaction fails!'], HTTPResponse::HTTP_BAD_REQUEST);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id): JsonResponse
    {
        $result = $this->interfacePaymentRepository->findById($id);
        if ($result->type == 0) {
            $this->interfaceOnlinePaymentRepository->deleteData($result->paymentable_id);
           // OnlinePayment::find($result->paymentable_id)->delete();
            $this->interfacePaymentRepository->deleteData($id);
            return response()->json(['message' => 'successfully your transaction!'], HTTPResponse::HTTP_OK);

        } elseif ($result->type == 1) {
            $this->interfaceOfflinePaymentRepository->deleteData($result->paymentable_id);
         //   OfflinePayment::find($result->paymentable_id)->delete();
            $this->interfacePaymentRepository->deleteData($id);
            return response()->json(['message' => 'successfully your transaction!'], HTTPResponse::HTTP_OK);

        } elseif ($result->type == 2) {

            $this->interfaceCashPaymentRepository->deleteData($result->paymentable_id);
          //  CashPayment::find($result->paymentable_id)->delete();
            $this->interfacePaymentRepository->deleteData($id);
            return response()->json(['message' => 'successfully your transaction!'], HTTPResponse::HTTP_OK);

        } else {
            return response()->json(['message' => 'sorry, your transaction fails!'], HTTPResponse::HTTP_BAD_REQUEST);

        }

    }
}
