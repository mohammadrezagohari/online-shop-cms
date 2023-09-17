<?php

namespace App\Http\Controllers\Market;

use App\Http\Controllers\Controller;
use App\Http\Requests\rate\RateRequest;
use App\Http\Resources\rate\RateResource;
use App\Repositories\MySQL\RateRepository\InterfaceRateRepository;
use Illuminate\Http\Request;

class RateController extends Controller
{
 private InterfaceRateRepository $interfaceRateRepository;
    public function __construct(InterfaceRateRepository $interfaceRateRepository)
    {
        $this->interfaceRateRepository=$interfaceRateRepository;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(RateRequest $request)
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
    public function destroy(string $id)
    {
        //
    }
}
