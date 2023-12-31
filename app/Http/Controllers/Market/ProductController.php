<?php

namespace App\Http\Controllers\Market;

use App\Http\Controllers\Controller;
use App\Http\Requests\product\ProductRequest;
use App\Http\Requests\product\StoreNoticesRequest;
use App\Http\Requests\product\StoreProductNoticeAmazingSaleRequest;
use App\Http\Requests\product\StoreProductRequest;
use App\Http\Requests\product\UpdateProductRequest;
use App\Http\Resources\resource\ProductResource;
use App\Models\Market\Product;
use App\Models\Market\ProductImage;
use App\Repositories\MySQL\AmazingSaleRepository\InterfaceAmazingSaleRepository;
use App\Repositories\MySQL\ProductRepository\InterfaceProductRepository;
use App\Repositories\MySQL\UserRepository\InterfaceUserRepository;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Symfony\Component\HttpFoundation\Response as HTTPResponse;

use function App\upload_asset_file;

/**
 * @group Product
 *
 *API endpoints for Product Services
 *
 *
 */
class ProductController extends Controller
{

    private InterfaceProductRepository $interfaceProductRepository;
    private InterfaceAmazingSaleRepository $interfaceAmazingSaleRepository;
    private InterfaceUserRepository $interfaceUserRepository;

    public function __construct(InterfaceProductRepository $interfaceProductRepository, InterfaceAmazingSaleRepository $interfaceAmazingSaleRepository, InterfaceUserRepository $interfaceUserRepository)
    {
        $this->interfaceProductRepository = $interfaceProductRepository;
        $this->interfaceAmazingSaleRepository = $interfaceAmazingSaleRepository;
        $this->interfaceUserRepository = $interfaceUserRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(ProductRequest $request): AnonymousResourceCollection
    {

        $count = @$request->count ?? 10;
        $name = @$request->name;
        $status = @$request->status;
        $category = @$request->category;
        $brand = @$request->brand;
        $order = @$request->order;
        $min_price = @$request->min_price;
        $max_price = @$request->max_price;

        $products = $this->interfaceProductRepository->query();

        if (@$name)
            $products = $products->whereName($name);

        if (@$category)

            $products = $products->whereCategory($category);

        if (@$brand)

            $products = $products->whereBrand($brand);

        if (@$status != null)

            $products = $products->whereStatus($status);


        if (@$min_price && @$max_price)

            $products = $products->whereBetweenMainAndMaxPrice($min_price, $max_price);


        if (@$order) {
            switch ($order) {
                case "most_visited":
                    $products = $products->whereMostVisited();
                    break;

                case "most_popular":
                    $products = $products->whereMostPopular();
                    break;
                case "newest":
                    $products = $products->whereNewest();
                    break;
                case "price_increase":
                    $products = $products->wherePriceIncrese();
                    break;
                case "price_decrese":
                    $products = $products->wherePriceDecrese();
                    break;
                case "favarite":
                    $products = $products->whereProductFavarite();
                    break;
                case "amazing":
                    $products = $products
                        ->join('amazing_sales', 'products.id', '=', 'amazing_sales.product_id')
                        ->where('amazing_sales.start_date', '<', Carbon::now())->where('amazing_sales.end_date', '>', Carbon::now())->where('amazing_sales.status', '=', 1)
                        ->where('products.status', '=', 1)
                        ->select('products.*', 'amazing_sales.*');
                    break;
            }
        }


        return ProductResource::collection($products->paginate($count));
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
    public function store(StoreProductRequest $request)
    {
        try {
            $data = $request->except(['_token']);

            $product = $this->interfaceProductRepository->insertData($data);
            foreach ($request->file('images') as $key => $image) {
                $url = upload_asset_file($image, "product-image");

                ProductImage::create([
                    'image' => $url,
                    'product_id' => $product->id
                ]);
            }
            return response()->json(['message' => 'successfully your transaction!'], HTTPResponse::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json(['message' => 'sorry, your transaction fails!'], HTTPResponse::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id): ProductResource
    {
        $product = $this->interfaceProductRepository->findById($id);
        $this->interfaceProductRepository->updateItem($id, [
            'product_viewer_counter' => $product['product_viewer_counter'] + 1
        ]);
        return ProductResource::make($this->interfaceProductRepository->findById($id));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, int $id): JsonResponse
    {

        if ($request->file('images')) {
            $data = $request->except(['_token', 'images']);
            $productImages = ProductImage::where('product_id', '=', $id)->get();

            foreach ($productImages as $image) {
                \File::delete($image->image);
                $image->delete();
            }

            foreach ($request->file('images') as $image) {
                $url = upload_asset_file($image, "product-image");
                ProductImage::create([
                    'image' => $url,
                    'product_id' => $id
                ]);
            }
        } else {
            $data = $request->except(['_token', 'images']);
        }
        if ($this->interfaceProductRepository->updateItem($id, $data))
            return response()->json(['message' => 'successfully your transaction!'], HTTPResponse::HTTP_OK);
        return response()->json(['message' => 'sorry, your transaction fails!'], HTTPResponse::HTTP_BAD_REQUEST);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id): JsonResponse
    {
        if ($this->interfaceProductRepository->deleteData($id))
            return response()->json(['message' => 'successfully your transaction!'], HTTPResponse::HTTP_OK);
        return response()->json(['message' => 'sorry, your transaction fails!'], HTTPResponse::HTTP_BAD_REQUEST);
    }


    public function storeAverageRate(int $id, Request $request)
    {

        $validation = \validator::make($request->only('rate'), [
            'rate' => 'required|string|in:1,2,3,4,5',
        ]);

        if ($validation->fails()) {
            return response()->json([
                'message' => $validation->messages(),
                'status' => false,
            ], HTTPResponse::HTTP_OK);
        }
        $product = $this->interfaceProductRepository->findById($id);
        if ($this->interfaceProductRepository->updateItem($id, [
            'average_rate' => ($product['average_rate'] + $request->input('rate')) / 2
        ]))
            return response()->json(['message' => 'successfully your transaction!'], HTTPResponse::HTTP_OK);
        return response()->json(['message' => 'sorry, your transaction fails!'], HTTPResponse::HTTP_BAD_REQUEST);
    }


    public function showLink(int $id)
    {

        $link = route("product.link", ['id' => $id]);

        if ($link)
            return response()->json(['data' => $link], HTTPResponse::HTTP_OK);
        return response()->json(['message' => 'sorry, your transaction fails!'], HTTPResponse::HTTP_BAD_REQUEST);
    }

    public function noticeForAmazingSales(StoreNoticesRequest $request)
    {
        $user = $this->interfaceUserRepository->findById($request->user_id);
        $product = $this->interfaceProductRepository->findById($request->product_id);

        $result = $user->customProducts()->wherePivot("product_id", "=", $product->id)->first();
        if ($result) {
            return response()->json(['message' => 'sorry, your transaction fails because data before inserted!'], HTTPResponse::HTTP_BAD_REQUEST);
        } else {
            $user->customProducts()->attach($product->id);
            return response()->json(['message' => 'successfully your transaction!'], HTTPResponse::HTTP_OK);
        }
    }
}
