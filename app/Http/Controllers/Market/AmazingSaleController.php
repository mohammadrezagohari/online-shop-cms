<?php

namespace App\Http\Controllers\Market;

use App\Http\Controllers\Controller;
use App\Http\Requests\amazingSale\AmazingSaleRequest;
use App\Http\Requests\amazingSale\StoreAmazingSaleRequest;
use App\Http\Requests\amazingSale\UpdateAmazingSaleRequest;
use App\Http\Resources\amzingSale\AmazingSaleResource;
use App\Repositories\MySQL\AmazingSaleRepository\InterfaceAmazingSaleRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response as HTTPResponse;

class AmazingSaleController extends Controller
{
    private InterfaceAmazingSaleRepository $interfaceAmazingSaleRepository;

    public function __construct(InterfaceAmazingSaleRepository $interfaceAmazingSaleRepository)
    {
        $this->interfaceAmazingSaleRepository = $interfaceAmazingSaleRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(AmazingSaleRequest $request)
    {
        $count = @$request->count ?? 10;
        $product_id = @$request->product_id;
        $status = @$request->status;
        $amazingSales = $this->interfaceAmazingSaleRepository->query();

        if (@$product_id)
            $amazingSales = $amazingSales->whereProductId($product_id);
        if (@$status != null)
            $amazingSales = $amazingSales->whereStatus($status);

        return AmazingSaleResource::collection($amazingSales->paginate($count));


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
    public function store(StoreAmazingSaleRequest $request):JsonResponse
    {
        $data = $request->except(['_token']);
        $data['start_date']=\Morilog\Jalali\Jalalian::fromFormat('Y-m-d H:i:s',$data['start_date'])->toCarbon();
        $data['end_date']=\Morilog\Jalali\Jalalian::fromFormat('Y-m-d H:i:s',$data['end_date'])->toCarbon();

        if ($this->interfaceAmazingSaleRepository->insertData($data))
            return response()->json(['message' => 'successfully your transaction!'], HTTPResponse::HTTP_OK);
        return response()->json(['message' => 'sorry, your transaction fails!'], HTTPResponse::HTTP_BAD_REQUEST);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id): AmazingSaleResource
    {
        return AmazingSaleResource::make($this->interfaceAmazingSaleRepository->findById($id));
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
    public function update(UpdateAmazingSaleRequest $request, int $id):JsonResponse
    {
        $data = $request->except(['_token']);
        if($request->has('start_date'))
            $data['start_date']=\Morilog\Jalali\Jalalian::fromFormat('Y-m-d H:i:s',$data['start_date'])->toCarbon();
        if($request->has('end_date'))
            $data['end_date']=\Morilog\Jalali\Jalalian::fromFormat('Y-m-d H:i:s',$data['end_date'])->toCarbon();

        if ($this->interfaceAmazingSaleRepository->updateItem($id, $data))
            return response()->json(['message' => 'successfully your transaction!'], HTTPResponse::HTTP_OK);
        return response()->json(['message' => 'sorry, your transaction fails!'], HTTPResponse::HTTP_BAD_REQUEST);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id):JsonResponse
    {
        if ($this->interfaceAmazingSaleRepository->deleteData($id))
            return response()->json(['message' => 'successfully your transaction!'], HTTPResponse::HTTP_OK);
        return response()->json(['message' => 'sorry, your transaction fails!'], HTTPResponse::HTTP_BAD_REQUEST);
    }

}
