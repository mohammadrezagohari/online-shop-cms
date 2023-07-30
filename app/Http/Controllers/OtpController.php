<?php

namespace App\Http\Controllers;

use App\Http\Requests\otp\OtpRequest;
use App\Http\Requests\otp\StoreOtpRequest;
use App\Http\Requests\otp\UpdateOtpRequest;
use App\Http\Resources\otp\OtpResource;
use App\Models\Otp;
use App\Repositories\MySQL\OtpRepository\InterfaceOtpRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Carbon;
use Symfony\Component\HttpFoundation\Response as HTTPResponse;
/**
 * @group Otp
 *
 *API endpoints for Otp Services
 *
 *
 */
class OtpController extends Controller
{
    private InterfaceOtpRepository $interfaceOtpRepository;


    public function __construct(InterfaceOtpRepository $interfaceOtpRepository)
    {
        $this->interfaceOtpRepository=$interfaceOtpRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(OtpRequest $request):AnonymousResourceCollection
    {
        $count = @$request->count ?? 10;
        $loginType = @$request->login_type;
        $userId = @$request->user_id;
        $otps=$this->interfaceOtpRepository->query();

        if(@$loginType)
            $otps->whereLoginType($loginType);
        if(@$userId)
            $otps->whereUserId($userId);

        $otps = $otps->paginate($count);

        return OtpResource::collection($otps);


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
    public function store(StoreOtpRequest $request)
    {
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id):OtpResource
    {
         return  OtpResource::make($this->interfaceOtpRepository->findById($id));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Otp $otp)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateOtpRequest $request, Otp $otp)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id):JsonResponse
    {
        if($this->interfaceOtpRepository->deleteData($id))
            return response()->json(['message' => 'successfully your transaction!'], HTTPResponse::HTTP_OK);
        return response()->json(['message' => 'sorry, your transaction fails!'], HTTPResponse::HTTP_BAD_REQUEST);
    }
}
