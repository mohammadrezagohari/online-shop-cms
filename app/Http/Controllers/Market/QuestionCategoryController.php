<?php

namespace App\Http\Controllers\Market;

use App\Http\Controllers\Controller;
use App\Http\Resources\questionCategory\QuestionCategoryResource;
use App\Repositories\MySQL\QuestionCategoryRepository\InterfaceQuestionCategoryRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Resources\Json\JsonResource;
use Symfony\Component\HttpFoundation\Response as HTTPResponse;


class QuestionCategoryController extends Controller
{

    private InterfaceQuestionCategoryRepository $interfaceQuestionCategoryRepository;


    public function __construct(InterfaceQuestionCategoryRepository $interfaceQuestionCategoryRepository)
    {
        $this->interfaceQuestionCategoryRepository = $interfaceQuestionCategoryRepository;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): AnonymousResourceCollection
    {
        $count = @$request->count ?? 10;
        $title = @$request->title;
        $questionCategories = $this->interfaceQuestionCategoryRepository->query();

        if ($title) {

            $questionCategories = $questionCategories->whereTitle($title);
        }

        return QuestionCategoryResource::collection($questionCategories->paginate($count));
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
    public function store(Request $request): JsonResponse
    {
        $validatedData = $request->validate([
            'title' => ['required', 'string', 'max:255'],
        ]);
        if (!$validatedData) {
            return response()->json([
                'status' => false,
                'message' => "sorry, your validation fails"
            ], HTTPResponse::HTTP_BAD_REQUEST);
        }

        $data = $request->except(["_token"]);

        if ($this->interfaceQuestionCategoryRepository->insertData($data))
            return response()->json(['message' => 'successfully your transaction!'], HTTPResponse::HTTP_OK);
        return response()->json(['message' => 'sorry, your transaction fails!'], HTTPResponse::HTTP_BAD_REQUEST);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id): QuestionCategoryResource
    {
        return QuestionCategoryResource::make($this->interfaceQuestionCategoryRepository->findById($id));
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
    public function update(Request $request, int $id)
    {

        $validatedData = $request->validate([
            'title' => ['nullable', 'string', 'max:255'],
        ]);

        if (!$validatedData) {
            return response()->json([
                'status' => false,
                'message' => "sorry,your validation  fails"
            ], HTTPResponse::HTTP_BAD_REQUEST);
        }

        $data = $request->except(["_token"]);

        if ($this->interfaceQuestionCategoryRepository->updateItem($id, $data))
            return response()->json(['message' => 'successfully your transaction!'], HTTPResponse::HTTP_OK);
        return response()->json(['message' => 'sorry, your transaction fails!'], HTTPResponse::HTTP_BAD_REQUEST);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        if ($this->interfaceQuestionCategoryRepository->deleteData($id))
            return response()->json(['message' => 'successfully your transaction!'], HTTPResponse::HTTP_OK);
        return response()->json(['message' => 'sorry, your transaction fails!'], HTTPResponse::HTTP_BAD_REQUEST);
    }
}
