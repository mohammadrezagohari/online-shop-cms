<?php

namespace App\Http\Controllers;

use App\Http\Requests\contact\ContactRequest;
use App\Http\Requests\contact\StoreContactRequest;
use App\Http\Requests\contact\UpdateContactRequest;
use App\Http\Resources\contact\ContactResource;
use App\Repositories\MySQL\ContactRepository\InterfaceContactRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Resources\Json\JsonResource;
use Symfony\Component\HttpFoundation\Response as HTTPResponse;


class ContactController extends Controller
{

    private InterfaceContactRepository $interfaceContactRepository;
    public function __construct(InterfaceContactRepository $interfaceContactRepository)
    {
        $this->interfaceContactRepository = $interfaceContactRepository;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(ContactRequest $request): AnonymousResourceCollection
    {
        $count = @$request->count ?? 10;
        $name = @$request->name;
        $email = @$request->email;
        $text = @$request->text;
        $contacts = $this->interfaceContactRepository->query();

        if (@$name)
            $contacts = $contacts->whereName($name);

        if (@$email)
            $contacts = $contacts->WhereEmail($email);

        if (@$text)
            $contacts = $contacts->whereText($text);



        return ContactResource::collection($contacts->paginate($count));
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
    public function store(StoreContactRequest $request): JsonResponse
    {
        $data = $request->except(['_token']);

        if ($this->interfaceContactRepository->insertData($data))
            return response()->json(['message' => 'successfully your transaction!'], HTTPResponse::HTTP_OK);
        return response()->json(['message' => 'sorry, your transaction fails!'], HTTPResponse::HTTP_BAD_REQUEST);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        return ContactResource::make($this->interfaceContactRepository->findById($id));
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
    public function update(UpdateContactRequest $request, int $id)
    {
        $data = $request->except(['_token']);

        if ($this->interfaceContactRepository->updateItem($id, $data))
            return response()->json(['message' => 'successfully your transaction!'], HTTPResponse::HTTP_OK);
        return response()->json(['message' => 'sorry, your transaction fails!'], HTTPResponse::HTTP_BAD_REQUEST);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        if ($this->interfaceContactRepository->deleteData($id))
            return response()->json(['message' => 'successfully your transaction!'], HTTPResponse::HTTP_OK);
        return response()->json(['message' => 'sorry, your transaction fails!'], HTTPResponse::HTTP_BAD_REQUEST);
    }
}
