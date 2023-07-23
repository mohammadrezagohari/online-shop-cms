<?php

namespace App\Http\Controllers\Market;

use App\Http\Controllers\Controller;
use App\Http\Requests\copan\CopanRequest;
use App\Http\Requests\copan\StoreCopanRequest;
use App\Http\Requests\copan\UpdateCopanRequest;
use App\Http\Resources\copan\CopanResource;
use App\Models\Market\Copan;
use App\Repositories\MySQL\CopanRepository\InterfaceCopanRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Symfony\Component\HttpFoundation\Response as HTTPResponse;

class CopanController extends Controller
{

    private InterfaceCopanRepository $interfaceCopanRepository;

    public function __construct(InterfaceCopanRepository $interfaceCopanRepository)
    {
        $this->interfaceCopanRepository = $interfaceCopanRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(CopanRequest $request): AnonymousResourceCollection
    {

        $count = @$request->count ?? 10;
        $code = @$request->code;
        $amount_type = @$request->amount_type;
        $type = @$request->type;
        $status = @$request->status;
        $copans = $this->interfaceCopanRepository->query();


        if (@$code)
            $copans = $copans->whereCode($code);
        if (@$amount_type != null)
            $copans = $copans->whereAmountType($amount_type);
        if (@$status != null)
            $copans = $copans->whereStatus($status);
        if (@$type != null)
            $copans = $copans->whereType($type);


        return CopanResource::collection($copans->paginate($count));


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
    public function store(StoreCopanRequest $request): JsonResponse
    {
        $data = $request->except(['_token']);
        if (@$data["type"] == 1) {
            if (@$request["user_id"] == null)
                return response()->json(['message' => 'sorry, your transaction fails because when type is 1 user_id must be send!'], HTTPResponse::HTTP_BAD_REQUEST);
        }
        $data['start_date'] = \Morilog\Jalali\Jalalian::fromFormat('Y-m-d H:i:s', $data['start_date'])->toCarbon();
        $data['end_date'] = \Morilog\Jalali\Jalalian::fromFormat('Y-m-d H:i:s', $data['end_date'])->toCarbon();

        if ($this->interfaceCopanRepository->insertData($data))
            return response()->json(['message' => 'successfully your transaction!'], HTTPResponse::HTTP_OK);
        return response()->json(['message' => 'sorry, your transaction fails!'], HTTPResponse::HTTP_BAD_REQUEST);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id): CopanResource
    {
        return CopanResource::make($this->interfaceCopanRepository->findById($id));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Copan $copan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCopanRequest $request, int $id):JsonResponse
    {
        $data = $request->except(['_token']);
        if (@$data['start_date'])
            $data['start_date'] = \Morilog\Jalali\Jalalian::fromFormat('Y-m-d H:i:s', $data['start_date'])->toCarbon();
        if (@$data['end_date'])
            $data['end_date'] = \Morilog\Jalali\Jalalian::fromFormat('Y-m-d H:i:s', $data['end_date'])->toCarbon();
        if (@$data["type"] == 1) {
            if ($request["user_id"] == null)
                return response()->json(['message' => 'sorry, your transaction fails because when type is 1 user_id must be send!'], HTTPResponse::HTTP_BAD_REQUEST);
        }
        if ($this->interfaceCopanRepository->updateItem($id, $data))
            return response()->json(['message' => 'successfully your transaction!'], HTTPResponse::HTTP_OK);
        return response()->json(['message' => 'sorry, your transaction fails!'], HTTPResponse::HTTP_BAD_REQUEST);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id):JsonResponse
    {
        if ($this->interfaceCopanRepository->deleteData($id))
            return response()->json(['message' => 'successfully your transaction!'], HTTPResponse::HTTP_OK);
        return response()->json(['message' => 'sorry, your transaction fails!'], HTTPResponse::HTTP_BAD_REQUEST);
    }
}
