<?php

namespace App\Http\Controllers\Market;

use App\Http\Controllers\Controller;
use App\Http\Requests\comment\CommentRequest;
use App\Http\Requests\comment\StoreCommentRequest;
use App\Http\Requests\comment\UpdateCommentRequest;
use App\Http\Resources\comment\CommentResource;
use App\Models\Market\Comment;
use App\Repositories\MySQL\CommentRepository\InterfaceCommentRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Symfony\Component\HttpFoundation\Response as HTTPResponse;

class CommentController extends Controller
{

    private  InterfaceCommentRepository $interfaceCommentRepository;

    public function __construct(InterfaceCommentRepository $interfaceCommentRepository)
    {

        $this->interfaceCommentRepository = $interfaceCommentRepository;
    }
    /**
     * Display a listing of the resource.
     * @param InterfaceCommentRepository $interfaceCommentRepository
     */
    public function index(CommentRequest $request):AnonymousResourceCollection
    {
        $count=@$request->count ?? 10;
        $user_id=@$request->user_id;
        $approved=@$request->approved;
        $status=@$request->status;
        $comments=$this->interfaceCommentRepository->query();

        if(@$status != null)
            $comments=$comments->whereStatus($status);
        if(@$user_id)
            $comments=$comments->whereUserId($user_id);
        if(@$approved)
            $comments=$comments->whereApproved($approved);


        return CommentResource::collection($comments->paginate($count));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(CommentRequest $request)
    {

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCommentRequest $request):JsonResponse
    {
        $data=$request->except(['_token']);
        if($data["type"]==0)
        {
            $data['commentable_id']=0;
            $data['commentable_type']="App\Models\Market\Post";

        }
        if($this->interfaceCommentRepository->insertData($data))
            return response()->json(['message' => 'successfully your transaction!'], HTTPResponse::HTTP_OK);
        return response()->json(['message' => 'sorry, your transaction fails!'], HTTPResponse::HTTP_BAD_REQUEST);
    }

    /**
     * Display the specified resource.
     */
    public function show(int  $id):CommentResource
    {
       return CommentResource::make($this->interfaceCommentRepository->findById($id));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Comment $comment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCommentRequest $request, int $id):JsonResponse
    {
        $data=$request->except(["_token"]);
        if($this->interfaceCommentRepository->updateItem($id,$data))
            return response()->json(['message' => 'successfully your transaction!'], HTTPResponse::HTTP_OK);
        return response()->json(['message' => 'sorry, your transaction fails!'], HTTPResponse::HTTP_BAD_REQUEST);
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id):JsonResponse
    {
       if($this->interfaceCommentRepository->deleteData($id))
           return response()->json(['message' => 'successfully your transaction!'], HTTPResponse::HTTP_OK);
        return response()->json(['message' => 'sorry, your transaction fails!'], HTTPResponse::HTTP_BAD_REQUEST);
    }
}
