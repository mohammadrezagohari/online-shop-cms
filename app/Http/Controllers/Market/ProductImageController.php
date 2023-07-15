<?php

namespace App\Http\Controllers\Market;

use App\Http\Controllers\Controller;
use App\Http\Requests\productImage\ProductImageRequest;
use App\Http\Requests\productImage\StoreProductImageRequest;
use App\Http\Requests\productImage\UpdateProductImageRequest;
use App\Http\Resources\productImage\ProductImageResource;
use App\Models\Market\ProductImage;
use App\Repositories\MySQL\ProductImageRepository\InterfaceProductImageRepository;
use Illuminate\Http\Client\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Symfony\Component\HttpFoundation\Response as HTTPResponse;
use function App\upload_asset_file;

class ProductImageController extends Controller
{
    private InterfaceProductImageRepository $interfaceProductImageRepository;

    public function __construct(InterfaceProductImageRepository $interfaceProductImageRepository)
    {
        $this->interfaceProductImageRepository = $interfaceProductImageRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(ProductImageRequest $request): AnonymousResourceCollection
    {
        $count = @$request->conunt ?? 10;
        $product_id = @$request->product_id;
        $productImages = $this->interfaceProductImageRepository->query();

        if (@$product_id)
            $productImages = $productImages->whereProductId($product_id);

        return ProductImageResource::collection($productImages->paginate($count));


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
    public function store(StoreProductImageRequest $request): JsonResponse
    {
        $product_id = $request->input('product_id');

        $images = $request->file('images');
        $result = null;

        foreach ($images as $image) {
            $result = ProductImage::create([
                'image' => upload_asset_file($image, "product-image"),
                'product_id' => $product_id
            ]);
        }
        if ($result)
            return response()->json(['message' => 'successfully your transaction!'], HTTPResponse::HTTP_OK);
        return response()->json(['message' => 'sorry, your transaction fails!'], HTTPResponse::HTTP_BAD_REQUEST);

    }

    /**
     * Display the specified resource.
     */
    public function show(int $id): ProductImageResource
    {
        return ProductImageResource::make($this->interfaceProductImageRepository->findById($id));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ProductImage $productImage)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductImageRequest $request, int $id)
    {
        $bool1 = false;
        $bool2 = false;
        if ($request->product_id) {
            $result = $this->interfaceProductImageRepository->findById($id);
            $result['product_id'] = $request->product_id;
            $result->save();
            $bool1 = true;
        }
        if ($request->hasFile('image')) {
            $result = $this->interfaceProductImageRepository->findById($id);
            \File::delete($result['image']);
            $result['image'] = upload_asset_file($request->image, "product-image");
            $result->save();
            $bool2 = true;
        }
        if ($bool1 != false or $bool2 != false)
            return response()->json(['message' => 'successfully your transaction!'], HTTPResponse::HTTP_OK);
        return response()->json(['message' => 'sorry, your transaction fails!'], HTTPResponse::HTTP_BAD_REQUEST);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id): JsonResponse
    {
        if ($this->interfaceProductImageRepository->deleteData($id))
            return response()->json(['message' => 'successfully your transaction!'], HTTPResponse::HTTP_OK);
        return response()->json(['message' => 'sorry, your transaction fails!'], HTTPResponse::HTTP_BAD_REQUEST);

    }
}
