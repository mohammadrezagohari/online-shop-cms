<?php

namespace App\Http\Controllers\Market;

use App\Http\Controllers\Controller;
use App\Http\Requests\productCategoryQuestion\ProductCategoryQuestionRequest;
use App\Http\Requests\productCategoryQuestion\StoreProductCategoryQuestionRequest;
use App\Http\Requests\productCategoryQuestion\UpdateProductCategoryQuestionRequest;
use App\Http\Resources\productCategoryQuestion\ProductCategoryQuestionResource;
use App\Repositories\MySQL\ProductCategoryQuestionRepository\InterfaceProductCategoryQuestionRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Symfony\Component\HttpFoundation\Response as HTTPResponse;


class ProductCategoryQuestionController extends Controller
{

    private InterfaceProductCategoryQuestionRepository $interfaceProductCategortQuestionRepository;


    public function __construct(InterfaceProductCategoryQuestionRepository $interfaceProductCategortQuestionRepository)
    {
        $this->interfaceProductCategortQuestionRepository = $interfaceProductCategortQuestionRepository;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(ProductCategoryQuestionRequest $request):AnonymousResourceCollection
    {


        $count = @$request->count ?? 10;
        $question = @$request->question;
        $category_id = @$request->category_id;

        $questions = $this->interfaceProductCategortQuestionRepository->query();

        if (@$question)
            $questions = $questions->whereQuestion($question);
        if (@$category_id)
            $questions = $questions->whereCategoryId($category_id);


        return ProductCategoryQuestionResource::collection($questions->paginate($count));
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
    public function store(StoreProductCategoryQuestionRequest $request):JsonResponse
    {
        $data = $request->except(["_token"]);

        if ($this->interfaceProductCategortQuestionRepository->insertData($data))
            return response()->json(['message' => 'successfully your transaction!'], HTTPResponse::HTTP_OK);
        return response()->json(['message' => 'sorry, your transaction fails!'], HTTPResponse::HTTP_BAD_REQUEST);
    }

    /**
     * Display the specified resource.
     */
    public function show(int  $id):ProductCategoryQuestionResource
    {
        return ProductCategoryQuestionResource::make($this->interfaceProductCategortQuestionRepository->findById($id));
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
    public function update(UpdateProductCategoryQuestionRequest $request, int $id):JsonResponse
    {
        $data = $request->except(["_token"]);

        if ($this->interfaceProductCategortQuestionRepository->updateItem($id, $data))
            return response()->json(['message' => 'successfully your transaction!'], HTTPResponse::HTTP_OK);
        return response()->json(['message' => 'sorry, your transaction fails!'], HTTPResponse::HTTP_BAD_REQUEST);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id):JsonResponse
    {
        if ($this->interfaceProductCategortQuestionRepository->deleteData($id))
            return response()->json(['message' => 'successfully your transaction!'], HTTPResponse::HTTP_OK);
        return response()->json(['message' => 'sorry, your transaction fails!'], HTTPResponse::HTTP_BAD_REQUEST);
    }
}
