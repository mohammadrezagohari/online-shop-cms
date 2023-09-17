<?php

namespace App\Http\Controllers\Market;

use App\Http\Controllers\Controller;
use App\Http\Requests\emailInsert\EmailInsertRequest;
use App\Http\Requests\emailInsert\StoreEmailInsertRequest;
use App\Http\Requests\emailInsert\UpdateEmailInsertRequest;
use App\Http\Resources\EmailInsert\EmailInsertResource;
use App\Repositories\MySQL\EmailInsertRepository\InterfaceEmailInsertRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Resources\Json\JsonResource;
use Symfony\Component\HttpFoundation\Response as HTTPResponse;


class EmailInsertController extends Controller
{
    private InterfaceEmailInsertRepository $interfaceEmailInsertRepository;
    public function __construct(InterfaceEmailInsertRepository $interfaceEmailInsertRepository)
    {
        $this->interfaceEmailInsertRepository=$interfaceEmailInsertRepository;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(EmailInsertRequest $request):AnonymousResourceCollection
    {
        $count = @$request->count ?? 10;
        $status = @$request->status;
        $email=@$request->email;

        $emails = $this->interfaceEmailInsertRepository->query();

        if (@$status != null)
            $emails = $emails->whereStatus($status);
        if (@$email)
            $emails = $emails->whereEmail($email);

        return EmailInsertResource::collection($emails->paginate($count));
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
    public function store(StoreEmailInsertRequest $request):JsonResponse
    {
       $data=$request->except(['token']);
       if ($this->interfaceEmailInsertRepository->insertData($data))
       return response()->json(['message' => 'successfully your transaction!'], HTTPResponse::HTTP_OK);
   return response()->json(['message' => 'sorry, your transaction fails!'], HTTPResponse::HTTP_BAD_REQUEST);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        return EmailInsertResource::make($this->interfaceEmailInsertRepository->findById($id));

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
    public function update(UpdateEmailInsertRequest $request, int $id)
    {
        $data = @$request->except(['_token']);

        if ($this->interfaceEmailInsertRepository->updateItem($id, $data))
        return response()->json(['message' => 'successfully your transaction!'], HTTPResponse::HTTP_OK);
    return response()->json(['message' => 'sorry, your transaction fails!'], HTTPResponse::HTTP_BAD_REQUEST);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        if ($this->interfaceEmailInsertRepository->deleteData($id))
        return response()->json(['message' => 'successfully your transaction!'], HTTPResponse::HTTP_OK);
    return response()->json(['message' => 'sorry, your transaction fails!'], HTTPResponse::HTTP_BAD_REQUEST);
    }
}
