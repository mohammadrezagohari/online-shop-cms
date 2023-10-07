<?php

namespace App\Http\Controllers\Market;

use App\Http\Controllers\Controller;
use App\Http\Requests\question\QuestionRequest;
use App\Http\Requests\question\StoreQuestionRequest;
use App\Http\Requests\question\UpdateQuestionRequest;
use App\Http\Resources\question\QuestionResource;
use App\Repositories\MySQL\QuestionRepository\InterfaceQuestionRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response as HTTPResponse;


class QuestionController extends Controller
{

    private InterfaceQuestionRepository $interfaceQuestionRepository;


    public function __construct(InterfaceQuestionRepository $interfaceQuestionRepository)
    {
        $this->interfaceQuestionRepository = $interfaceQuestionRepository;
    }



    /**
     * Display a listing of the resource.
     */
    public function index(QuestionRequest $request): AnonymousResourceCollection
    {

        @$count = $request->count ?? 10;
        @$title = $request->title;
        @$mini_description = $request->mini_description;
        @$full_description = $request->full_description;
        @$status = $request->status;
        $questions = $this->interfaceQuestionRepository->query();
        if (@$title) {
            $questions = $questions->whereTitle($title);
        }
        if (@$mini_description) {
            $questions = $questions->whereMiniDescription($mini_description);
        }
        if (@$full_description) {
            $questions = $questions->whereFullDescription($full_description);
        }
        if (@$status != null) {
            $questions = $questions->whereStatus($status);
        }

        return QuestionResource::collection($questions->paginate($count));
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
    public function store(StoreQuestionRequest $request): JsonResponse
    {
        $data = $request->except(["_token"]);


        if ($this->interfaceQuestionRepository->insertData($data))
            return response()->json(['message' => 'successfully your transaction!'], HTTPResponse::HTTP_OK);
        return response()->json(['message' => 'sorry, your transaction fails!'], HTTPResponse::HTTP_BAD_REQUEST);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id):QuestionResource
    {
        return QuestionResource::make($this->interfaceQuestionRepository->findById($id));
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
    public function update(UpdateQuestionRequest $request, string $id):JsonResponse
    {
        $data = $request->except(["_token"]);

        if ($this->interfaceQuestionRepository->updateItem($id, $data))
            return response()->json(['message' => 'successfully your transaction!'], HTTPResponse::HTTP_OK);
        return response()->json(['message' => 'sorry, your transaction fails!'], HTTPResponse::HTTP_BAD_REQUEST);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
       if($this->interfaceQuestionRepository->deleteData($id))
       return response()->json(['message' => 'successfully your transaction!'], HTTPResponse::HTTP_OK);
       return response()->json(['message' => 'sorry, your transaction fails!'], HTTPResponse::HTTP_BAD_REQUEST);
    }


    public function isHelpQuestion(Request $request,int $id){
        
        $validatedData = $request->validate([
            'help' => ['required', 'numeric', 'in:0,1'],
        ]);
        if (!$validatedData) {
            return response()->json([
                'status' => false,
                'message' => "sorry, your validation fails"
            ], HTTPResponse::HTTP_BAD_REQUEST);
        }

      $data = $request->except(["_token"]);
     $question=$this->interfaceQuestionRepository->findById($id);
     if($data['help']=="0"){
        if($this->interfaceQuestionRepository->updateItem($id,[
            "dislike"=>$question["dislike"]+1
        ]))
        return response()->json(['message' => 'successfully your transaction!'], HTTPResponse::HTTP_OK);
     }else{
        if($this->interfaceQuestionRepository->updateItem($id,[
            "like"=>$question["like"]+1
        ]))
        return response()->json(['message' => 'successfully your transaction!'], HTTPResponse::HTTP_OK);
     }
     return response()->json(['message' => 'sorry, your transaction fails!'], HTTPResponse::HTTP_BAD_REQUEST);


    }
}
