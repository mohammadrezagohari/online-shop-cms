<?php

namespace App\Http\Controllers\Market;

use App\Events\SendSms;
use App\Http\Controllers\Controller;
use App\Http\Requests\sms\SmsRequest;
use App\Http\Requests\sms\StoreSmsRequest;
use App\Http\Requests\sms\UpdateSmsRequest;
use App\Http\Resources\sms\SmsResource;
use App\Jobs\SendSmsForAllUsers;
use App\Models\User;
use App\Notifications\InvoicePaid;
use App\Repositories\MySQL\SmsRepository\InterfaceSmsRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Symfony\Component\HttpFoundation\Response as HTTPResponse;

/**
 * @group Sms
 *
 *API endpoints for Sms Services
 *
 *
 */
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
    public function index(SmsRequest $request): AnonymousResourceCollection
    {
        $count = @$request->count ?? 10;
        $title = @$request->title;
        $published_at = @$request->published_at;
        $status = @$request->status;
        $smses = $this->interfaceSmsRepository->query();

        if ($status != null)
            $smses = $smses->whereStatus($status);
        if ($title)
            $smses = $smses->whereTitle($title);
        if ($published_at)
            $smses = $smses->wherePublishedAt($published_at);

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
    public function store(StoreSmsRequest $request): JsonResponse
    {
        $data = $request->except(['_token']);
        $data['published_at'] = \Morilog\Jalali\Jalalian::fromFormat('Y-m-d H:i:s', $data['published_at'])->toCarbon();
        if ($this->interfaceSmsRepository->insertData($data))
            return response()->json(['message' => 'successfully your transaction!'], HTTPResponse::HTTP_OK);
        return response()->json(['message' => 'sorry, your transaction fails!'], HTTPResponse::HTTP_BAD_REQUEST);
    }


    /**
     * Display the specified resource.
     */
    public function show(int $id): SmsResource
    {
        return SmsResource::make($this->interfaceSmsRepository->findById($id));
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
    public function update(UpdateSmsRequest $request, int $id): JsonResponse
    {
        $data = @$request->except(['_token']);
        if (@$data['published_at'])
            $data['published_at'] = \Morilog\Jalali\Jalalian::fromFormat('Y-m-d H:i:s', $data['published_at'])->toCarbon();
        if ($this->interfaceSmsRepository->updateItem($id, $data))
            return response()->json(['message' => 'successfully your transaction!'], HTTPResponse::HTTP_OK);
        return response()->json(['message' => 'sorry, your transaction fails!'], HTTPResponse::HTTP_BAD_REQUEST);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id): JsonResponse
    {
        if ($this->interfaceSmsRepository->deleteData($id))
            return response()->json(['message' => 'successfully your transaction!'], HTTPResponse::HTTP_OK);
        return response()->json(['message' => 'sorry, your transaction fails!'], HTTPResponse::HTTP_BAD_REQUEST);

    }

    public function sendSms(int $id)
    {

        if ($sms = $this->interfaceSmsRepository->findById($id)) {
            SendSmsForAllUsers::dispatch($sms['body']);
            $sms['published_at'] = now();
            return response()->json(['message' => 'successfully your transaction!'], HTTPResponse::HTTP_OK);

        }
        return response()->json(['message' => 'sorry, your transaction fails!'], HTTPResponse::HTTP_BAD_REQUEST);


    }
}
