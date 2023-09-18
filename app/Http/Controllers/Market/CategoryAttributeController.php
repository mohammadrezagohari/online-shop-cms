<?php

namespace App\Http\Controllers\Market;

use App\Http\Controllers\Controller;
use App\Http\Requests\categoryAttribute\CategoryAttributeRequest;
use App\Http\Requests\categoryAttribute\StoreCategoryAttributeRequest;
use App\Http\Requests\categoryAttribute\UpdateCategoryAttributeRequest;
use App\Http\Resources\categoryAttribute\CategoryAttributeResource;
use App\Repositories\MySQL\CategoryAttributeRepository\InterfaceCategoryAttributeRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Symfony\Component\HttpFoundation\Response as HTTPResponse;


class CategoryAttributeController extends Controller
{
    private InterfaceCategoryAttributeRepository $interfaceCategoryAttributeRepository;
    public function __construct(InterfaceCategoryAttributeRepository $interfaceCategoryAttributeRepository)
    {
        $this->interfaceCategoryAttributeRepository = $interfaceCategoryAttributeRepository;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(CategoryAttributeRequest $request): AnonymousResourceCollection
    {
        $count = @$request->count ?? 10;
        $name = @$request->name;
        $unit = @$request->unit;
        $categorry_id = @$request->category_id;
        $categoryAttributes = $this->interfaceCategoryAttributeRepository->query();

        if (@$name)
            $categoryAttributes = $categoryAttributes->whereName($name);
        if (@$unit)
            $categoryAttributes = $categoryAttributes->whereUnit($unit);
        if (@$categorry_id)
            $categoryAttributes = $categoryAttributes->whereCategoryId($categorry_id);

        return CategoryAttributeResource::collection($categoryAttributes->paginate($count));
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
    public function store(StoreCategoryAttributeRequest $request): JsonResponse
    {
        $data = $request->except(['_token']);

        if ($this->interfaceCategoryAttributeRepository->insertData($data))
            return response()->json(['message' => 'successfully your transaction!'], HTTPResponse::HTTP_OK);
        return response()->json(['message' => 'sorry, your transaction fails!'], HTTPResponse::HTTP_BAD_REQUEST);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        return CategoryAttributeResource::make($this->interfaceCategoryAttributeRepository->findById($id));
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
    public function update(UpdateCategoryAttributeRequest $request, int $id)
    {
        $data = $request->except(['_token']);

        if ($this->interfaceCategoryAttributeRepository->updateItem($id, $data))
            return response()->json(['message' => 'successfully your transaction!'], HTTPResponse::HTTP_OK);
        return response()->json(['message' => 'sorry, your transaction fails!'], HTTPResponse::HTTP_BAD_REQUEST);
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        if ($this->interfaceCategoryAttributeRepository->deleteData($id))
            return response()->json(['message' => 'successfully your transaction!'], HTTPResponse::HTTP_OK);
        return response()->json(['message' => 'sorry, your transaction fails!'], HTTPResponse::HTTP_BAD_REQUEST);
    }
}
