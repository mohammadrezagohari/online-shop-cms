<?php

namespace App\Http\Controllers\Market;

use App\Http\Controllers\Controller;
use App\Http\Requests\articleCategory\ArticleCategoryRequest;
use App\Http\Requests\articleCategory\StoreArticleCategoryRequest;
use App\Http\Requests\articleCategory\UpdateArticleCategoryRequest;
use App\Http\Resources\articleCategory\ArticleCategoryResource;
use App\Repositories\MySQL\ArticleCategoryRepository\InterfaceArticleCategoryRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Symfony\Component\HttpFoundation\Response as HTTPResponse;


class ArticleCategoryController extends Controller
{
    private InterfaceArticleCategoryRepository $interfaceArticleCategoryRepository;
    public function __construct(InterfaceArticleCategoryRepository $interfaceArticleCategoryRepository)
    {
        $this->interfaceArticleCategoryRepository = $interfaceArticleCategoryRepository;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(ArticleCategoryRequest $request): AnonymousResourceCollection
    {
        $articlesCategories = $this->interfaceArticleCategoryRepository->query();
        $count = @$request->count ?? 10;
        $name = @$request->name;
        $description = @$request->description;
        $status = @$request->status;

        if (@$name)
            $articlesCategories = $articlesCategories->whereName($name);
        if (@$description)
            $articlesCategories = $articlesCategories->whereDescription($description);
        if (@$status != null)
            $articlesCategories = $articlesCategories->whereStatus($status);

        return ArticleCategoryResource::collection($articlesCategories->paginate($count));
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
    public function store(StoreArticleCategoryRequest $request): JsonResponse
    {
        $data = $request->except(['_token']);

        if ($this->interfaceArticleCategoryRepository->insertData($data))
            return response()->json(['message' => 'successfully your transaction!'], HTTPResponse::HTTP_OK);
        return response()->json(['message' => 'sorry, your transaction fails!'], HTTPResponse::HTTP_BAD_REQUEST);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id): ArticleCategoryResource
    {
        return ArticleCategoryResource::make($this->interfaceArticleCategoryRepository->findById($id));
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
    public function update(UpdateArticleCategoryRequest $request, int $id)
    {
        $data = $request->except(['_token']);

        if ($this->interfaceArticleCategoryRepository->updateItem($id, $data))
            return response()->json(['message' => 'successfully your transaction!'], HTTPResponse::HTTP_OK);
        return response()->json(['message' => 'sorry, your transaction fails!'], HTTPResponse::HTTP_BAD_REQUEST);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        if ($this->interfaceArticleCategoryRepository->deleteData($id))
            return response()->json(['message' => 'successfully your transaction!'], HTTPResponse::HTTP_OK);
        return response()->json(['message' => 'sorry, your transaction fails!'], HTTPResponse::HTTP_BAD_REQUEST);
    }
}
