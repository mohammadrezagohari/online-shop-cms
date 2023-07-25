<?php

namespace App\Http\Controllers\Market;

use App\Http\Controllers\Controller;
use App\Http\Requests\post\PostRequest;
use App\Http\Requests\post\StorePostRequest;
use App\Http\Requests\post\UpdatePostRequest;
use App\Http\Resources\post\PostResource;
use App\Models\Market\Post;
use App\Repositories\MySQL\PostRepository\InterfacePostRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Symfony\Component\HttpFoundation\Response as HTTPResponse;
use function App\upload_asset_file;

class PostController extends Controller
{

    private InterfacePostRepository $interfacePostRepository;

    public function __construct(InterfacePostRepository $interfacePostRepository)
    {

        $this->interfacePostRepository = $interfacePostRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(PostRequest $request):AnonymousResourceCollection
    {
        $count = @$request->count ?? 10;
        $title = @$request->title;
        $status = @$request->status;
        $user_id = @$request->user_id;
        $category_id = @$request->category_id;
        $posts = $this->interfacePostRepository->query();

        if (@$title)
            $posts = $posts->whereTitle($title);
        if (@$status != null)
            $posts = $posts->whereStatus($status);
        if (@$user_id)
            $posts = $posts->whereUserId($user_id);
        if (@$category_id)
            $posts = $posts->whereCategoryId($category_id);


        return PostResource::collection($posts->paginate($count));


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
    public function store(StorePostRequest $request):JsonResponse
    {
      $data=$request->except(['_token']);
      $image=upload_asset_file( $request->file('image'),'post');
      $data['image']=$image;

      if($this->interfacePostRepository->insertData($data))
          return response()->json(['message' => 'successfully your transaction!'], HTTPResponse::HTTP_OK);
        return response()->json(['message' => 'sorry, your transaction fails!'], HTTPResponse::HTTP_BAD_REQUEST);

    }

    /**
     * Display the specified resource.
     */
    public function show(int $id):PostResource
    {
        return PostResource::make($this->interfacePostRepository->findById($id));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePostRequest $request, int $id)
    {
      $data=$request->except(["_token"]);
      if($request->hasFile('image')){
         $image_url=$this->interfacePostRepository->findById($id)['image'];
         \File::delete(public_path($image_url));
          $data['image']= upload_asset_file($request->file('image'),'post');
      }
      if ($this->interfacePostRepository->updateItem($id,$data))
          return response()->json(['message' => 'successfully your transaction!'], HTTPResponse::HTTP_OK);
        return response()->json(['message' => 'sorry, your transaction fails!'], HTTPResponse::HTTP_BAD_REQUEST);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
       $image_url=$this->interfacePostRepository->findById($id)['image'];
      \File::delete(public_path($image_url));
      if($this->interfacePostRepository->deleteData($id))
          return response()->json(['message' => 'successfully your transaction!'], HTTPResponse::HTTP_OK);
        return response()->json(['message' => 'sorry, your transaction fails!'], HTTPResponse::HTTP_BAD_REQUEST);

    }
}
