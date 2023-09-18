<?php

namespace App\Http\Controllers\Market;

use App\Http\Controllers\Controller;
use App\Http\Requests\rate\RateRequest;
use App\Http\Requests\rate\StoreRateRequest;
use App\Http\Requests\rate\UpdateRateRequest;
use App\Http\Resources\rate\RateResource;
use App\Repositories\MySQL\ProductRepository\InterfaceProductRepository;
use App\Repositories\MySQL\RateRepository\InterfaceRateRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Symfony\Component\HttpFoundation\Response as HTTPResponse;


class RateController extends Controller
{
    private InterfaceRateRepository $interfaceRateRepository;
    private InterfaceProductRepository $interfaceProductRepository;
    public function __construct(InterfaceRateRepository $interfaceRateRepository, InterfaceProductRepository $interfaceProductRepository)
    {
        $this->interfaceRateRepository = $interfaceRateRepository;
        $this->interfaceProductRepository = $interfaceProductRepository;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(RateRequest $request): AnonymousResourceCollection
    {
        $count = @$request->count ?? 10;
        $user_id = @$request->user_id;
        $product_id = @$request->product_id;

        $rates = $this->interfaceRateRepository->query();

        if (@$product_id)

            $rates = $rates->whereProductId($product_id);

        if (@$user_id)
            $rates = $rates->whereUserId($user_id);


        return RateResource::collection($rates->paginate($count));
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
    public function store(StoreRateRequest $request): JsonResponse
    {
        $data = $request->except(['_token']);
        $rate = $this->interfaceRateRepository->checkUserInsertProductRate($data['user_id'], $data['product_id']);
        if ($rate)
            return response()->json(['message' => 'sorry, your rate before stored !'], HTTPResponse::HTTP_BAD_REQUEST);
        if ($this->interfaceRateRepository->insertData($data)) {
            $product = $this->interfaceProductRepository->findById($data['product_id']);
            if ($this->interfaceProductRepository->updateItem($data['product_id'], [
                'average_rate' => ($product['average_rate'] + $data['rate']) / 2
            ])) {
                return response()->json(['message' => 'successfully your transaction!'], HTTPResponse::HTTP_OK);
            }
        }
        return response()->json(['message' => 'sorry, your transaction fails!'], HTTPResponse::HTTP_BAD_REQUEST);
    }



    /**
     * Display the specified resource.
     */
    public function show(int $id): RateResource
    {
        return RateResource::make($this->interfaceRateRepository->findById($id));
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
    public function update(UpdateRateRequest $request, int $id)
    {

        $rate = $this->interfaceRateRepository->findById($id);
        if ($rate['rate'] == $request['rate']) {
            return response()->json(['message' => 'your rate before with this rate inserted!'], HTTPResponse::HTTP_OK);
        }
        if ($this->interfaceRateRepository->updateItem($id, ['rate' => $request['rate']])) {
            $product = $this->interfaceProductRepository->findById($rate['product_id']);
            if ($request['rate'] > $rate['rate']) {
                $result = $request['rate'] - $rate['rate'];
                if ($this->interfaceProductRepository->updateItem($rate['product_id'], [
                    'average_rate' => ($product['average_rate'] + $result) / 2
                ])) {
                    return response()->json(['message' => 'successfully your transaction!'], HTTPResponse::HTTP_OK);
                }
            } else {
                $result = $rate['rate'] - $request['rate'];
                if ($this->interfaceProductRepository->updateItem($rate['product_id'], [
                    'average_rate' => ($product['average_rate'] - $result) / 2
                ])) {
                    return response()->json(['message' => 'successfully your transaction!'], HTTPResponse::HTTP_OK);
                }
            }
        }
        return response()->json(['message' => 'sorry, your transaction fails!'], HTTPResponse::HTTP_BAD_REQUEST);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
