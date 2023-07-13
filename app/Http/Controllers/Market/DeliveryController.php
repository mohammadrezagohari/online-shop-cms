<?php

namespace App\Http\Controllers\Market;

use App\Http\Controllers\Controller;
use App\Http\Requests\delivery\DeliveryRequest;
use App\Http\Requests\delivery\StoreDeliveryRequest;
use App\Http\Requests\delivery\UpdateDeliveryRequest;
use App\Http\Resources\delivery\DeliveryResource;
use App\Models\Market\Delivery;
use App\Repositories\MySQL\DeliveryRepository\InterfaceDeliveryRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Symfony\Component\HttpFoundation\Response as HTTPResponse;

class DeliveryController extends Controller
{
    private InterfaceDeliveryRepository $interfaceDeliveryRepository;

    public function __construct(InterfaceDeliveryRepository $interfaceDeliveryRepository)
    {
        $this->interfaceDeliveryRepository = $interfaceDeliveryRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(DeliveryRequest $request):AnonymousResourceCollection
    {
        $count = @$request->count ?? 10;
        $name = @$request->name;
        $status = @$request->status;
        $deliveries = $this->interfaceDeliveryRepository->query();

        if (@$name)
            $deliveries = $deliveries->whereName($name);
        if (@$status!=null)
          $deliveries=$deliveries->whereStatus($status);


        $deliveries = $deliveries->paginate($count);

        return DeliveryResource::collection($deliveries);

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
    public function store(StoreDeliveryRequest $request)
    {
        $data=$request->except(['_token']);
        if($this->interfaceDeliveryRepository->insertData($data))
            return response()->json(['message' => 'successfully your transaction!'], HTTPResponse::HTTP_OK);
        return response()->json(['message' => 'sorry, your transaction fails!'], HTTPResponse::HTTP_BAD_REQUEST);
    }

    /**
     * Display the specified resource.
     */
    public function show(int  $id):DeliveryResource
    {
        return DeliveryResource::make($this->interfaceDeliveryRepository->findById($id));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Delivery $delivery)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDeliveryRequest $request, int $id):JsonResponse
    {
        $data=$request->except(['_token']);
        if($this->interfaceDeliveryRepository->updateItem($id,$data))
            return response()->json(['message' => 'successfully your transaction!'], HTTPResponse::HTTP_OK);
        return response()->json(['message' => 'sorry, your transaction fails!'], HTTPResponse::HTTP_BAD_REQUEST);
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id):JsonResponse
    {
        if($this->interfaceDeliveryRepository->deleteData($id))
            return response()->json(['message' => 'successfully your transaction!'], HTTPResponse::HTTP_OK);
        return response()->json(['message' => 'sorry, your transaction fails!'], HTTPResponse::HTTP_BAD_REQUEST);
    }
}
