<?php

namespace App\Http\Controllers\Market;

use App\Http\Controllers\Controller;
use App\Http\Requests\offlinePayment\OfflinePaymentRequest;
use App\Http\Requests\offlinePayment\StoreOfflinePaymentRequest;
use App\Http\Requests\offlinePayment\UpdateOfflinePaymentRequest;
use App\Http\Resources\offlinePayment\OfflinePaymentResource;
use App\Models\Market\OfflinePayment;
use App\Repositories\MySQL\OfflinePaymentRepository\InterfaceOfflinePaymentRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Symfony\Component\HttpFoundation\Response as HTTPResponse;

class OfflinePaymentController extends Controller
{
    private InterfaceOfflinePaymentRepository $interfaceOfflinePaymentRepository;


    public function __construct(InterfaceOfflinePaymentRepository $interfaceOfflinePaymentRepository)
    {
        $this->interfaceOfflinePaymentRepository = $interfaceOfflinePaymentRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(OfflinePaymentRequest $request):AnonymousResourceCollection
    {
        $count = @$request->count ?? 10;
        $user_id = @$request->user_id;
        $status = @$request->status;
        $offlinePayments = $this->interfaceOfflinePaymentRepository->query();

        if (@$user_id)

            $offlinePayments = $offlinePayments->whereUserId($user_id);
        if (@$status !=  null)
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
    public function store(StoreOfflinePaymentRequest $request):JsonResponse
    {
        $data=$request->except(['_token']);
        if($this->interfaceOfflinePaymentRepository->insertData($data))
            return response()->json(['message' => 'successfully your transaction!'], HTTPResponse::HTTP_OK);
        return response()->json(['message' => 'sorry, your transaction fails!'], HTTPResponse::HTTP_BAD_REQUEST);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id):OfflinePaymentResource
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
        $data=$request->except(['_token']);
        if($this->interfaceOfflinePaymentRepository->updateItem($id,$data))
            return response()->json(['message' => 'successfully your transaction!'], HTTPResponse::HTTP_OK);
        return response()->json(['message' => 'sorry, your transaction fails!'], HTTPResponse::HTTP_BAD_REQUEST);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int  $id):JsonResponse
    {
        if($this->interfaceOfflinePaymentRepository->deleteData($id))
            return response()->json(['message' => 'successfully your transaction!'], HTTPResponse::HTTP_OK);
        return response()->json(['message' => 'sorry, your transaction fails!'], HTTPResponse::HTTP_BAD_REQUEST);
    }
}
