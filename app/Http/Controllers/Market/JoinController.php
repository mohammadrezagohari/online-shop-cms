<?php

namespace App\Http\Controllers\Market;

use App\Http\Controllers\Controller;
use App\Http\Requests\join\JoinRequest;
use App\Http\Requests\join\StoreJoinRequest;
use App\Http\Requests\join\UpdateJoinRequest;
use App\Http\Resources\join\JoinResource;
use App\Repositories\MySQL\JoinRepository\InterfaceJoinRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Resources\Json\JsonResource;
use Symfony\Component\HttpFoundation\Response as HTTPResponse;


class JoinController extends Controller
{
    private InterfaceJoinRepository $interfaceJoinRepository;

    public function __construct(InterfaceJoinRepository $interfaceJoinRepository)
    {
        $this->interfaceJoinRepository = $interfaceJoinRepository;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(JoinRequest $request): AnonymousResourceCollection
    {
        $count = @$request->count ?? 10;
        $first_name = @$request->first_name;
        $last_name = @$request->last_name;
        $email = @$request->email;
        $company_name = @$request->company_name;
        $mobile = @$request->mobile;
        $brand_registration = @$request->brand_registration;
        $status = @$request->status;
        $joins = $this->interfaceJoinRepository->query();

        if (@$first_name)
            $joins = $joins->whereFirstName($first_name);
        if (@$last_name)
            $joins = $joins->whereLastName($last_name);
        if (@$email)
            $joins = $joins->whereEmail($email);
        if (@$company_name)
            $joins = $joins->whereCompanyName($company_name);
        if (@$mobile)
            $joins = $joins->whereMobile($mobile);
        if (@$brand_registration)
            $joins = $joins->whereBrandRegistration($brand_registration);
        if (@$status)
            $joins = $joins->whereStatus($status);

        return JoinResource::collection($joins->paginate($count));
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
    public function store(StoreJoinRequest $request): JsonResponse
    {
        $data = $request->except(["_token"]);
        $data["brands"] = json_encode($request->brands);

        if ($this->interfaceJoinRepository->insertData($data))
            return response()->json(['message' => 'successfully your transaction!'], HTTPResponse::HTTP_OK);
        return response()->json(['message' => 'sorry, your transaction fails!'], HTTPResponse::HTTP_BAD_REQUEST);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id): JsonResource
    {
        return JoinResource::make($this->interfaceJoinRepository->findById($id));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateJoinRequest $request, int $id):JsonResponse
    {
        $data = $request->except(["_token"]);

        if ($this->interfaceJoinRepository->updateItem($id, $data))
            return response()->json(['message' => 'successfully your transaction!'], HTTPResponse::HTTP_OK);
        return response()->json(['message' => 'sorry, your transaction fails!'], HTTPResponse::HTTP_BAD_REQUEST);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id):JsonResponse
    {
        if ($this->interfaceJoinRepository->deleteData($id))
            return response()->json(['message' => 'successfully your transaction!'], HTTPResponse::HTTP_OK);
        return response()->json(['message' => 'sorry, your transaction fails!'], HTTPResponse::HTTP_BAD_REQUEST);
    }
}
