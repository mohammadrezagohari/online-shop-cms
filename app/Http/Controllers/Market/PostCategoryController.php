<?php

namespace App\Http\Controllers\Market;

use App\Http\Controllers\Controller;
use App\Http\Requests\postCategory\PostCategoryRequest;
use App\Http\Requests\postCategory\StorePostCategoryRequest;
use App\Http\Requests\postCategory\UpdatePostCategoryRequest;
use App\Http\Resources\PostCategoryResource;
use App\Models\PostCategory;
use App\Repositories\MySQL\PostCategoryRepository\InterfacePostCategoryRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Symfony\Component\HttpFoundation\Response as HTTPResponse;
/**
 * @group PostCategory
 *
 *API endpoints for PostCategory Services
 *
 *
 */
class PostCategoryController extends Controller
{

    private InterfacePostCategoryRepository $interfacePostCategoryRepository;

    public function __construct(InterfacePostCategoryRepository $interfacePostCategoryRepository)
    {

        $this->interfacePostCategoryRepository = $interfacePostCategoryRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(PostCategoryRequest $request):AnonymousResourceCollection
    {

        $count = @$request->count ?? 10;
        $name = @$request->name;
        $status = @$request->status;
        $postCategories = $this->interfacePostCategoryRepository->query();


        if (@$status != null)
            $postCategories = $postCategories->whereStatus($status);

        if (@$name)
            $postCategories = $postCategories->where('name', 'like', "%{$name}%");

        return PostCategoryResource::collection($postCategories->paginate($count));


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
    public function store(StorePostCategoryRequest $request):JsonResponse
    {

        $data = $request->except(["_token"]);

        if ($this->interfacePostCategoryRepository->insertData($data))
            return response()->json(['message' => 'successfully your transaction!'], HTTPResponse::HTTP_OK);
        return response()->json(['message' => 'sorry, your transaction fails!'], HTTPResponse::HTTP_BAD_REQUEST);

    }

    /**
     * Display the specified resource.
     */
    public function show(int $id):PostCategoryResource
    {
        return PostCategoryResource::make($this->interfacePostCategoryRepository->findById($id));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PostCategory $postCategory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePostCategoryRequest $request, int $id):JsonResponse
    {
        $data=@$request->except(["_token"]);

        if($this->interfacePostCategoryRepository->updateItem($id,$data))
            return response()->json(['message' => 'successfully your transaction!'], HTTPResponse::HTTP_OK);
        return response()->json(['message' => 'sorry, your transaction fails!'], HTTPResponse::HTTP_BAD_REQUEST);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id):JsonResponse
    {
        if($this->interfacePostCategoryRepository->deleteData($id))
            return response()->json(['message' => 'successfully your transaction!'], HTTPResponse::HTTP_OK);
        return response()->json(['message' => 'sorry, your transaction fails!'], HTTPResponse::HTTP_BAD_REQUEST);

    }
}
