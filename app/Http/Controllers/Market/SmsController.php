<?php

namespace App\Http\Controllers\Market;

use App\Http\Controllers\Controller;
use App\Http\Requests\sms\SmsRequest;
use App\Http\Requests\sms\StoreSmsRequest;
use App\Http\Resources\sms\SmsResource;
use App\Repositories\MySQL\SmsRepository\InterfaceSmsRepository;
use Illuminate\Http\Request;

class SmsController extends Controller
{

    private InterfaceSmsRepository $interfaceSmsRepository;

    public function __construct(InterfaceSmsRepository $interfaceSmsRepository)
    {

        $this->interfaceSmsRepository = $interfaceSmsRepository;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(SmsRequest $request)
    {
      $count=@$request->count ?? 10;
      $title=@$request->title;
      $published_at=@$request->published_at;
      $status=@$request->status;
      $smses=$this->interfaceSmsRepository->query();

      if($status != null)
        $smses=$smses->whereStatus($status);
      if($title)
          $smses=$smses->whereTitle($title);
      if($published_at)
          $smses=$smses->wherePublishedAt($published_at);

      return SmsResource::collection($smses->paginate($count));




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
    public function store(StoreSmsRequest $request)
    {
     $data=$request->except(['_token']);

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
