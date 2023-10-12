<?php

namespace App\Http\Controllers\Market;

use App\Http\Controllers\Controller;
use App\Http\Requests\helpSize\HelpSizeRequest;
use App\Http\Requests\helpSize\StoreHelpSizeRequest;
use App\Http\Requests\helpSize\UpdateHelpSizeRequest;
use App\Http\Resources\helpSize\HelpSizeResource;
use App\Repositories\MySQL\HelpSizeRepository\InterfaceHelpSizeRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Symfony\Component\HttpFoundation\Response as HTTPResponse;


class HelpSizeController extends Controller
{
    private InterfaceHelpSizeRepository $interfaceHelpSizeRepository;


    public function __construct(InterfaceHelpSizeRepository $interfaceHelpSizeRepository)
    {
        $this->interfaceHelpSizeRepository = $interfaceHelpSizeRepository;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(HelpSizeRequest $request): AnonymousResourceCollection
    {
        $count = @$request->count ?? 10;
        $size = @$request->size;
        $height = @$request->height;
        $waist = @$request->waist;
        $sleeveـlength = @$request->sleeveـlength;
        $product_id = @$request->product_id;
        $status = @$request->status;
        $helpSizes = $this->interfaceHelpSizeRepository->query();

        if (@$size)
            $helpSizes = $helpSizes->wheresize($size);
        if (@$height)
            $helpSizes = $helpSizes->whereHeight($height);
        if (@$waist)
            $helpSizes = $helpSizes->whereWaist($waist);
        if (@$sleeveـlength)
            $helpSizes = $helpSizes->whereSleeveLength($sleeveـlength);
        if (@$product_id)
            $helpSizes = $helpSizes->whereProductId($product_id);
        if (@$status)
            $helpSizes = $helpSizes->whereStatus($status);

        return HelpSizeResource::collection($helpSizes->paginate($count));
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
    public function store(StoreHelpSizeRequest $request):JsonResponse
    {
        $data = $request->except(["_token"]);
        if ($this->interfaceHelpSizeRepository->insertData($data))
            return response()->json(['message' => 'successfully your transaction!'], HTTPResponse::HTTP_OK);
        return response()->json(['message' => 'sorry, your transaction fails!'], HTTPResponse::HTTP_BAD_REQUEST);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id):HelpSizeResource
    {
        return HelpSizeResource::make($this->interfaceHelpSizeRepository->findById($id));
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
    public function update(UpdateHelpSizeRequest $request, int $id):JsonResponse
    {
         $data = $request->except(["_token"]);
        if ($this->interfaceHelpSizeRepository->updateItem($id, $data))
            return response()->json(['message' => 'successfully your transaction!'], HTTPResponse::HTTP_OK);
        return response()->json(['message' => 'sorry, your transaction fails!'], HTTPResponse::HTTP_BAD_REQUEST);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id):JsonResponse
    {
        if ($this->interfaceHelpSizeRepository->deleteData($id))
            return response()->json(['message' => 'successfully your transaction!'], HTTPResponse::HTTP_OK);
        return response()->json(['message' => 'sorry, your transaction fails!'], HTTPResponse::HTTP_BAD_REQUEST);
    }
}
