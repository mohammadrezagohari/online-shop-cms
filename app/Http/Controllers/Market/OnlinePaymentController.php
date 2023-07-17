<?php

namespace App\Http\Controllers\Market;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreOnlinePaymentRequest;
use App\Http\Requests\UpdateOnlinePaymentRequest;
use App\Models\Market\OnlinePayment;

class OnlinePaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

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
    public function store(StoreOnlinePaymentRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(OnlinePayment $onlinePayment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(OnlinePayment $onlinePayment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateOnlinePaymentRequest $request, OnlinePayment $onlinePayment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(OnlinePayment $onlinePayment)
    {
        //
    }
}
