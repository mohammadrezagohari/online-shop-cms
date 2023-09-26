<?php

namespace App\Http\Controllers\Market;

use App\Http\Controllers\Controller;
use App\Http\Requests\categoryValue\CategoryValueRequest;
use App\Http\Requests\categoryValue\StoreCategoryValueRequest;
use App\Http\Requests\categoryValue\UpdateCategoryValueRequest;
use App\Http\Resources\categoryValue\CategoryValueResource;
use App\Repositories\MySQL\CategoryValueRepository\InterfaceCategoryValueRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Symfony\Component\HttpFoundation\Response as HTTPResponse;
use Symfony\Component\VarExporter\Internal\Values;

class CategoryValueController extends Controller
{
    private InterfaceCategoryValueRepository $interfaceCategoryValueRepository;
    public function __construct(InterfaceCategoryValueRepository $interfaceCategoryValueRepository)
    {
        $this->interfaceCategoryValueRepository = $interfaceCategoryValueRepository;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(CategoryValueRequest $request) //: AnonymousResourceCollection
    {

        $count = @$request->count ?? 10;
        $product_id = @$request->product_id;
        $category_attribute_id = @$request->category_attribute_id;
        $value = @$request->value;
        $min_price = @$request->min_price;
        $max_price = @$request->max_price;
        $values = @$request->values;
        $categoryValues = $this->interfaceCategoryValueRepository->query();

        if (@$product_id)
            $categoryValues = $categoryValues->whereProductId($product_id);
        if (@$category_attribute_id)
            $categoryValues = $categoryValues->whereCategoryAttributesId($category_attribute_id);
        if (@$value)
            $categoryValues = $categoryValues->whereValue($value);
        if (@$values)
            $categoryValues = $categoryValues->whereIn('id', $values);
        if (@$min_price && @$max_price){
            $categoryValues = $categoryValues->whereHas("product",function($q) use($min_price,$max_price){
                $q->where('price','>=',$min_price)
                ->where('price','<=',$max_price);
            });
        }


        return CategoryValueResource::collection($categoryValues->paginate($count));
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
    public function store(StoreCategoryValueRequest $request): JsonResponse
    {
        $data = $request->except(['_token']);

        if ($this->interfaceCategoryValueRepository->insertData($data))
            return response()->json(['message' => 'successfully your transaction!'], HTTPResponse::HTTP_OK);
        return response()->json(['message' => 'sorry, your transaction fails!'], HTTPResponse::HTTP_BAD_REQUEST);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id): CategoryValueResource
    {
        return CategoryValueResource::make($this->interfaceCategoryValueRepository->findById($id));
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
    public function update(UpdateCategoryValueRequest $request, int $id)
    {
        $data = $request->except(['_token']);


        if ($this->interfaceCategoryValueRepository->updateItem($id, $data))
            return response()->json(['message' => 'successfully your transaction!'], HTTPResponse::HTTP_OK);
        return response()->json(['message' => 'sorry, your transaction fails!'], HTTPResponse::HTTP_BAD_REQUEST);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        if ($this->interfaceCategoryValueRepository->deleteData($id))
            return response()->json(['message' => 'successfully your transaction!'], HTTPResponse::HTTP_OK);
        return response()->json(['message' => 'sorry, your transaction fails!'], HTTPResponse::HTTP_BAD_REQUEST);
    }
}
