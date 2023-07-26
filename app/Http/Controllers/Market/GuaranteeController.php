<?php

namespace App\Http\Controllers\Market;

use App\Http\Controllers\Controller;
use App\Http\Requests\guarantee\GuaranteeRequest;
use App\Http\Requests\guarantee\StoreGuaranteeRequest;
use App\Http\Requests\guarantee\UpdateGuaranteeRequest;
use App\Http\Resources\guarantee\GuaranteeResource;
use App\Models\Market\Guarantee;
use App\Repositories\MySQL\GuaranteeRepository\InterfaceGuaranteeRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Symfony\Component\HttpFoundation\Response as HTTPResponse;

class GuaranteeController extends Controller
{

    private InterfaceGuaranteeRepository $interfaceGuaranteeRepository;

    public function __construct(InterfaceGuaranteeRepository $interfaceGuaranteeRepository)
    {
        $this->interfaceGuaranteeRepository = $interfaceGuaranteeRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(GuaranteeRequest $request):AnonymousResourceCollection
    {
        $count = @$request->count ?? 10;
        $name = @$request->name;
        $status = @$request->status;
        $guarantees = $this->interfaceGuaranteeRepository->query();

        if (@$name)
            $guarantees = $guarantees->whereName($name);
        if (@$status!=null)
            $guarantees = $guarantees->whereStatus($status);
        return GuaranteeResource::collection($guarantees->paginate($count));

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
    public function store(StoreGuaranteeRequest $request):JsonResponse
    {
        $data=$request->except(['_torken']);
        if($this->interfaceGuaranteeRepository->insertData($data))

            return response()->json(['message' => 'successfully your transaction!'], HTTPResponse::HTTP_OK);
        return response()->json(['message' => 'sorry, your transaction fails!'], HTTPResponse::HTTP_BAD_REQUEST);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id):GuaranteeResource
    {
        return GuaranteeResource::make($this->interfaceGuaranteeRepository->findById($id));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Guarantee $guarantee)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateGuaranteeRequest $request, int $id):JsonResponse
    {
        $data=@$request->except(['_token']);
        if($this->interfaceGuaranteeRepository->updateItem($id,$data))
            return response()->json(['message' => 'successfully your transaction!'], HTTPResponse::HTTP_OK);
        return response()->json(['message' => 'sorry, your transaction fails!'], HTTPResponse::HTTP_BAD_REQUEST);
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int  $id):JsonResponse
    {
        if($this->interfaceGuaranteeRepository->deleteData($id))
            return response()->json(['message' => 'successfully your transaction!'], HTTPResponse::HTTP_OK);
        return response()->json(['message' => 'sorry, your transaction fails!'], HTTPResponse::HTTP_BAD_REQUEST);
    }
}
