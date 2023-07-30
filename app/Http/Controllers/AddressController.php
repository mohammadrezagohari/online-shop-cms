<?php

namespace App\Http\Controllers;

use App\Http\Requests\address\AddressRequest;
use App\Http\Requests\address\StoreAddressRequest;
use App\Http\Requests\address\UpdateAddressRequest;
use App\Http\Resources\address\AddressResource;
use App\Models\Address;
use App\Repositories\MySQL\AddressRepository\InterfaceAddressRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Symfony\Component\HttpFoundation\Response as HTTPResponse;

/**
 * @group Address
 *
 *API endpoints for Address Services
 *
 *
 */

class AddressController extends Controller
{
    private InterfaceAddressRepository $interfaceAddressRepository;

    public function __construct(InterfaceAddressRepository $interfaceAddressRepository)
    {
        $this->interfaceAddressRepository = $interfaceAddressRepository;
    }



    public function index(AddressRequest $request):AnonymousResourceCollection
    {
        $count = @$request->count ?? 10;
        $postalCode = @$request->postal_code;
        $userId = @$request->user_id;

        $addresses = $this->interfaceAddressRepository->query();
        if (@$userId)
            $addresses = $addresses->whereUserId($userId);
        if (@$postalCode)
            $addresses = $addresses->wherePostalCode($postalCode);
        $addresses = $addresses->paginate($count);

        return AddressResource::collection($addresses);


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
    public function store(StoreAddressRequest $request): JsonResponse
    {
        $data = $request->except(["_token"]);
        if ($this->interfaceAddressRepository->insertData($data))
             return response()->json(['message' => 'successfully your transaction!'], HTTPResponse::HTTP_OK);
        return response()->json(['message' => 'sorry, your transaction fails!'], HTTPResponse::HTTP_BAD_REQUEST);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id): AddressResource
    {
        return AddressResource::make($this->interfaceAddressRepository->findById($id));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Address $address)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAddressRequest $request, int $id):JsonResponse
    {
        $data=$request->except(['_token']);
        if($this->interfaceAddressRepository->updateItem($id,$data))
            return response()->json(['message' => 'successfully your transaction!'], HTTPResponse::HTTP_OK);
        return response()->json(['message' => 'sorry, your transaction fails!'], HTTPResponse::HTTP_BAD_REQUEST);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id):JsonResponse
    {

        if($this->interfaceAddressRepository->deleteData($id))
            return response()->json(['message' => 'successfully your transaction!'], HTTPResponse::HTTP_OK);
        return response()->json(['message' => 'sorry, your transaction fails!'], HTTPResponse::HTTP_BAD_REQUEST);
    }
}
