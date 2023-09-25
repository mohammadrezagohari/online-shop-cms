<?php

namespace App\Http\Controllers\Market;

use App\Http\Controllers\Controller;
use App\Http\Requests\productSocial\ProductSocialRequest;
use App\Http\Requests\productSocial\StoreProductSocialRequest;
use App\Http\Requests\productSocial\UpdateProductSocialRequest;
use App\Http\Resources\productSocial\ProductSocialResource;
use App\Repositories\MySQL\ProductSocialRepository\InterfaceProductSocialRepository;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response as HTTPResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

use function App\upload_asset_file;

class ProductSocialController extends Controller
{

    private InterfaceProductSocialRepository $interfaceProductSocialRepository;

    public function __construct(InterfaceProductSocialRepository $interfaceProductSocialRepository)
    {
        $this->interfaceProductSocialRepository = $interfaceProductSocialRepository;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(ProductSocialRequest $request): AnonymousResourceCollection
    {
        $count = @$request->count ?? 10;
        $title = @$request->title;
        $product_id = @$request->product_id;
        $link = @$request->link;


        $productSocials = $this->interfaceProductSocialRepository->query();
        if (@$title)
            $productSocials = $productSocials->whereTitle($title);
        if (@$product_id)
            $productSocials = $productSocials->whereProductId($product_id);
        if (@$link)
            $productSocials = $productSocials->whereLink($link);



        return ProductSocialResource::collection($productSocials->paginate($count));
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
    public function store(StoreProductSocialRequest $request): JsonResponse
    {
        $data = $request->except(['_token']);

        $data['icon'] = upload_asset_file($request->file('icon'), 'product-social');

        if ($this->interfaceProductSocialRepository->insertData($data))
            return response()->json(['message' => 'successfully your transaction!'], HTTPResponse::HTTP_OK);
        return response()->json(['message' => 'sorry, your transaction fails!'], HTTPResponse::HTTP_BAD_REQUEST);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id): ProductSocialResource
    {
        return ProductSocialResource::make($this->interfaceProductSocialRepository->findById($id));
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
    public function update(UpdateProductSocialRequest $request, int $id):JsonResponse
    {
        $data = $request->except(['_token']);

        if ($request->hasFile('icon')) {
            $image_url = $this->interfaceProductSocialRepository->findById($id)['icon'];
            \File::delete(public_path($image_url));
            $data['icon'] = upload_asset_file($request->file('icon'), 'product_social');
        }

        if ($this->interfaceProductSocialRepository->updateItem($id, $data))
            return response()->json(['message' => 'successfully your transaction!'], HTTPResponse::HTTP_OK);
        return response()->json(['message' => 'sorry, your transaction fails!'], HTTPResponse::HTTP_BAD_REQUEST);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id):JsonResponse
    {
        $image_url = $this->interfaceProductSocialRepository->findById($id)['icon'];
        \File::delete(public_path($image_url));


        if ($this->interfaceProductSocialRepository->deleteData($id))
            return response()->json(['message' => 'successfully your transaction!'], HTTPResponse::HTTP_OK);
        return response()->json(['message' => 'sorry, your transaction fails!'], HTTPResponse::HTTP_BAD_REQUEST);
    }
}
