<?php

namespace App\Http\Controllers\Market;

use App\Http\Controllers\Controller;
use App\Http\Requests\rateAverage\RateAverageRequest;
use App\Http\Requests\rateAverage\StoreRateAverageRequest;
use App\Http\Resources\rateAverage\RateAverageResource;
use App\Repositories\MySQL\RateAverageRepository\InterfaceRateAverageRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Symfony\Component\HttpFoundation\Response as HTTPResponse;


class RateAverageController extends Controller
{

    private InterfaceRateAverageRepository $interfaceRateAverageRepository;

    public function __construct(InterfaceRateAverageRepository $interfaceRateAverageRepository)
    {
        $this->interfaceRateAverageRepository = $interfaceRateAverageRepository;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(RateAverageRequest $request): AnonymousResourceCollection
    {
        $count = @$request->count ?? 10;
        $product_category_question_id = @$request->product_category_question_id;
        $product_id = @$request->product_id;
        $status = @$request->status;

        $rateAverages = $this->interfaceRateAverageRepository->query();

        if (@$product_id)

            $rateAverages = $rateAverages->whereProductId($product_id);

        if (@$product_category_question_id)
            $rateAverages = $rateAverages->whereProductCategoryQuestionId($product_category_question_id);

        if (@$status)
            $rateAverages = $rateAverages->whereStatus($status);


        return RateAverageResource::collection($rateAverages->paginate($count));
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
    public function store(StoreRateAverageRequest $request):JsonResponse
    {

        $data = $request->except(["_token"]);
        $result = $this->interfaceRateAverageRepository->getRateAverageRowWithProductIdAndProductCategoryQuestionId($data["product_id"], $data["product_category_question_id"]);

        if ($result) {
            if ($this->interfaceRateAverageRepository->updateItem($result["id"], [
                "average_rate" => ($result["average_rate"] + $data["rate"]) / 2,
                "insert_rate_count" => $result["insert_rate_count"] + 1,
            ]))
                return response()->json(['message' => 'successfully your transaction!'], HTTPResponse::HTTP_OK);
            return response()->json(['message' => 'sorry, your transaction fails!'], HTTPResponse::HTTP_BAD_REQUEST);
        } else {
            $data["average_rate"] = $data["rate"];
            $data["insert_rate_count"] = 1;
            if ($this->interfaceRateAverageRepository->insertData($data))
                return response()->json(['message' => 'successfully your transaction!'], HTTPResponse::HTTP_OK);
            return response()->json(['message' => 'sorry, your transaction fails!'], HTTPResponse::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id):RateAverageResource
    {
        return RateAverageResource::make($this->interfaceRateAverageRepository->findById($id));
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
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id):JsonResponse
    {
        if ($this->interfaceRateAverageRepository->deleteData($id))
            return response()->json(['message' => 'successfully your transaction!'], HTTPResponse::HTTP_OK);
        return response()->json(['message' => 'sorry, your transaction fails!'], HTTPResponse::HTTP_BAD_REQUEST);
    }
}
