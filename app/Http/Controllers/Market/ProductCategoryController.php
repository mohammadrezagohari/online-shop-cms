<?php

namespace App\Http\Controllers\Market;

use App\Http\Controllers\Controller;
use App\Http\Requests\productCategory\ProductCategoryRequest;
use App\Http\Requests\productCategory\StoreProductCategoryRequest;
use App\Http\Requests\productCategory\UpdateProductCategoryRequest;
use App\Http\Resources\productCategory\ProductCategoryResource;
use App\Models\Market\ProductCategory;
use App\Repositories\MySQL\ProductCategoryRepository\InterfaceProductCategoryRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Symfony\Component\HttpFoundation\Response as HTTPResponse;
use function App\upload_asset_file;

/**
 * @group ProductCategory
 *
 *API endpoints for ProductCategory Services
 *
 *
 */
class ProductCategoryController extends Controller
{
    private InterfaceProductCategoryRepository $interfaceProductCategoryRepository;

    public function __construct(InterfaceProductCategoryRepository $interfaceProductCategoryRepository)
    {
        $this->interfaceProductCategoryRepository = $interfaceProductCategoryRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(ProductCategoryRequest $request) //: AnonymousResourceCollection
    { //if user nothing send parent and parent null or parent equals one parent
        $count = @$request->count ?? 10;
        $name = @$request->name;
        $parent = @$request->parent;
        $english_name = @$request->english_name;
        $status = @$request->status;
        $productCategories = $this->interfaceProductCategoryRepository->query();

        if(@$parent){
            if(@$parent=="null"){
                $productCategories = $productCategories->where('parent_id',"=",null);
            }else{
                $productCategories = $productCategories->where('parent_id',"=",@$parent);

            }
        }
       
      
        if (@$name)
            $productCategories = $productCategories->whereName($name);

        if (@$english_name)
            $productCategories = $productCategories->whereEnglishName($english_name);


        if (@$status != null)
            $productCategories = $productCategories->whereStatus($status);

        return ProductCategoryResource::collection($productCategories->paginate($count));
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
    public function store(StoreProductCategoryRequest $request)
    {
        $data = $request->except(['_token']);
        $image = $request->file('image');
        $data['image'] = upload_asset_file($image, 'product-category');

        if ($this->interfaceProductCategoryRepository->insertData($data))
            return response()->json(['message' => 'successfully your transaction!'], HTTPResponse::HTTP_OK);
        return response()->json(['message' => 'sorry, your transaction fails!'], HTTPResponse::HTTP_BAD_REQUEST);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id): ProductCategoryResource
    {
        return ProductCategoryResource::make($this->interfaceProductCategoryRepository->findById($id));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ProductCategory $productCategory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductCategoryRequest $request, int $id): JsonResponse
    {
        $data = $request->except(['_token']);
        if ($request->file('image')) {
            $data['image'] = upload_asset_file($request->file('image'), 'product-category');
            \File::delete($this->interfaceProductCategoryRepository->findById($id)['image']);
            if ($this->interfaceProductCategoryRepository->updateItem($id, $data))
                return response()->json(['message' => 'successfully your transaction!'], HTTPResponse::HTTP_OK);
            return response()->json(['message' => 'sorry, your transaction fails!'], HTTPResponse::HTTP_BAD_REQUEST);
        }


        if ($this->interfaceProductCategoryRepository->updateItem($id, $data))
            return response()->json(['message' => 'successfully your transaction!'], HTTPResponse::HTTP_OK);
        return response()->json(['message' => 'sorry, your transaction fails!'], HTTPResponse::HTTP_BAD_REQUEST);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id) //: JsonResponse
    {

        $image_url = $this->interfaceProductCategoryRepository->findById($id)['image'];

        \File::delete(public_path($image_url));


        if ($this->interfaceProductCategoryRepository->deleteData($id))
            return response()->json(['message' => 'successfully your transaction!'], HTTPResponse::HTTP_OK);
        return response()->json(['message' => 'sorry, your transaction fails!'], HTTPResponse::HTTP_BAD_REQUEST);
    }
}
