<?php

namespace App\Http\Controllers\Market;

use App\Http\Controllers\Controller;
use App\Http\Requests\article\ArticleRequest;
use App\Http\Requests\article\StoreArticleRequest;
use App\Http\Requests\article\UpdateArticleRequest;
use App\Http\Resources\article\ArticleResource;
use App\Repositories\MySQL\ArticleRepository\InterfaceArticleRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Symfony\Component\HttpFoundation\Response as HTTPResponse;

use function App\upload_asset_file;

class ArticleController extends Controller
{
    private InterfaceArticleRepository $interfaceArticleRepository;
    public function __construct(InterfaceArticleRepository $interfaceArticleRepository)
    {
        $this->interfaceArticleRepository = $interfaceArticleRepository;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(ArticleRequest $request): AnonymousResourceCollection
    {

        $articles = $this->interfaceArticleRepository->query();
        $count = @$request->count ?? 10;

        $title = @$request->title;
        $author_id = @$request->author_id;
        $selected_content = @$request->selected_content;
        $product_category_id = @$request->product_category_id;
        $article_category_id = @$request->article_category_id;
        $order = @$request->order;

        if (@$title)
            $articles = $articles->whereTitle($title);
        if (@$author_id)
            $articles = $articles->whereAuthorId($author_id);
        if (@$selected_content != null)
            $articles = $articles->whereSelectedContent();

        if (@$product_category_id)
            $articles = $articles->whereProductCategoryId($product_category_id);
        if (@$article_category_id)
            $articles = $articles->whereArticleCategoryId($article_category_id);


            if (@$order) {
                switch ($order) {
                    case "most_visited":
                        $articles = $articles->whereMostVisited();
                        break;
    
                    case "selected_content":
                        $articles = $articles->whereSelectedContent();
                        break;
                    case "newest":
                        $articles = $articles->whereNewest();
                        break;
                }
            }


        return ArticleResource::collection($articles->paginate($count));
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
    public function store(StoreArticleRequest $request): JsonResponse
    {
        $data = $request->except(['_token']);
        $data['image'] = upload_asset_file($request->file('image'), 'article');
        if ($this->interfaceArticleRepository->insertData($data))
            return response()->json(['message' => 'successfully your transaction!'], HTTPResponse::HTTP_OK);
        return response()->json(['message' => 'sorry, your transaction fails!'], HTTPResponse::HTTP_BAD_REQUEST);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id): ArticleResource
    {
        $article = $this->interfaceArticleRepository->findById($id);
        $this->interfaceArticleRepository->updateItem($id, [
            'count_viewer' => $article['count_viewer'] + 1
        ]);
        return ArticleResource::make($this->interfaceArticleRepository->findById($id));
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
    public function update(UpdateArticleRequest $request, int $id)
    {
        $data = $request->except(['_token']);
        if ($request->hasFile('image')) {
            $image_url = $this->interfaceArticleRepository->findById($id)['image'];
            \File::delete(public_path($image_url));

            $data['image'] = upload_asset_file($request->file('image'), 'article');
        }
        if ($this->interfaceArticleRepository->updateItem($id, $data))
            return response()->json(['message' => 'successfully your transaction!'], HTTPResponse::HTTP_OK);
        return response()->json(['message' => 'sorry, your transaction fails!'], HTTPResponse::HTTP_BAD_REQUEST);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        $image_url = $this->interfaceArticleRepository->findById($id)['image'];

        \File::delete(public_path($image_url));

        if ($this->interfaceArticleRepository->deleteData($id))
            return response()->json(['message' => 'successfully your transaction!'], HTTPResponse::HTTP_OK);
        return response()->json(['message' => 'sorry, your transaction fails!'], HTTPResponse::HTTP_BAD_REQUEST);
    }
}
