<?php

namespace App\Http\Controllers;

use App\Http\Requests\news\NewsRequest;
use App\Http\Requests\news\StoreNewsRequest;
use App\Http\Requests\news\UpdateNewsRequest;
use App\Http\Resources\news\NewsResource;
use App\Repositories\MySQL\NewsRepository\InterfaceNewsRepository;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response as HTTPResponse;


class NewsController extends Controller
{
    private InterfaceNewsRepository $interfaceNewsRepository;
    public function __construct(InterfaceNewsRepository $interfaceNewsRepository)
    {
        $this->interfaceNewsRepository = $interfaceNewsRepository;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(NewsRequest $request)
    {
        $news = $this->interfaceNewsRepository->query();
        $count = @$request->count ?? 10;
        $email = @$request->email;
        $status = @$request->status;
        if (@$email)
            $news = $news->whereEmail($email);
        if (@$status != null)
            $news = $news->whereStatus($status);

        return NewsResource::collection($news->paginate($count));
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
    public function store(StoreNewsRequest $request)
    {
        $data = $request->except(['_token']);

        if ($this->interfaceNewsRepository->insertData($data))
            return response()->json(['message' => 'successfully your transaction!'], HTTPResponse::HTTP_OK);
        return response()->json(['message' => 'sorry, your transaction fails!'], HTTPResponse::HTTP_BAD_REQUEST);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        return NewsResource::make($this->interfaceNewsRepository->findById($id));
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
    public function update(UpdateNewsRequest $request, int $id)
    {
        $data = $request->except(['_token']);

        if ($this->interfaceNewsRepository->updateItem($id, $data))
            return response()->json(['message' => 'successfully your transaction!'], HTTPResponse::HTTP_OK);
        return response()->json(['message' => 'sorry, your transaction fails!'], HTTPResponse::HTTP_BAD_REQUEST);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        if ($this->interfaceNewsRepository->deleteData($id))
        return response()->json(['message' => 'successfully your transaction!'], HTTPResponse::HTTP_OK);
    return response()->json(['message' => 'sorry, your transaction fails!'], HTTPResponse::HTTP_BAD_REQUEST);

    }
}
