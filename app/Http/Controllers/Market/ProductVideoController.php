<?php

namespace App\Http\Controllers\Market;

use App\Http\Controllers\Controller;
use App\Http\Requests\productVideo\ProductVideoRequest;
use App\Http\Requests\productVideo\StoreProductVideoRequest;
use App\Http\Requests\productVideo\UpdateProductVideoRequest;
use App\Http\Resources\productVideos\ProductVideoResource;
use App\Repositories\MySQL\ProductVideoRepository\InterfaceProductVideoRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Symfony\Component\HttpFoundation\Response as HTTPResponse;
use function App\upload_asset_file;

class ProductVideoController extends Controller
{

    private InterfaceProductVideoRepository $interfaceProductVideoRepository;
    public function __construct(InterfaceProductVideoRepository $interfaceProductVideoRepository)
    {
        $this->interfaceProductVideoRepository = $interfaceProductVideoRepository;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(ProductVideoRequest $request): AnonymousResourceCollection
    {
        $count = @$request->count ?? 10;
        $title = @$request->title;
        $product_id = @$request->product_id;
        $url = @$request->url;
        $productVideos = $this->interfaceProductVideoRepository->query();

        if (@$title)
            $productVideos = $productVideos->whereTitle($title);
        if (@$product_id)
            $productVideos = $productVideos->whereProductId($product_id);
        if (@$url)
            $productVideos = $productVideos->whereUrl($url);



        return ProductVideoResource::collection($productVideos->paginate($count));
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
    public function store(StoreProductVideoRequest $request): JsonResponse
    {
        $data = $request->except(['_token']);
        $data['url'] = upload_asset_file($request->file('video'), 'product-video');

        if ($this->interfaceProductVideoRepository->insertData($data))
            return response()->json(['message' => 'successfully your transaction!'], HTTPResponse::HTTP_OK);
        return response()->json(['message' => 'sorry, your transaction fails!'], HTTPResponse::HTTP_BAD_REQUEST);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id): ProductVideoResource
    {
        return ProductVideoResource::make($this->interfaceProductVideoRepository->findById($id));
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
    public function update(UpdateProductVideoRequest $request, int $id): JsonResponse
    {
        $data = $request->except(['_token', 'video']);

        if ($request->hasFile('video')) {
            $video_url = $this->interfaceProductVideoRepository->findById($id)['url'];
            \File::delete(public_path($video_url));
            $data['url'] = upload_asset_file($request->file('video'), 'product-video');
        }

        if ($this->interfaceProductVideoRepository->updateItem($id, $data))
            return response()->json(['message' => 'successfully your transaction!'], HTTPResponse::HTTP_OK);
        return response()->json(['message' => 'sorry, your transaction fails!'], HTTPResponse::HTTP_BAD_REQUEST);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id): JsonResponse
    {
        $video_url = $this->interfaceProductVideoRepository->findById($id)['url'];

        \File::delete(public_path($video_url));
        if ($this->interfaceProductVideoRepository->deleteData($id))
            return response()->json(['message' => 'successfully your transaction!'], HTTPResponse::HTTP_OK);
        return response()->json(['message' => 'sorry, your transaction fails!'], HTTPResponse::HTTP_BAD_REQUEST);
    }
}
