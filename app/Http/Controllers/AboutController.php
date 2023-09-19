<?php

namespace App\Http\Controllers;

use App\Http\Requests\about\AboutRequest;
use App\Http\Requests\about\StoreAboutRequest;
use App\Http\Requests\about\UpdateAboutRequest;
use App\Http\Resources\about\AboutResource;
use App\Repositories\MySQL\AboutRepository\InterfaceAboutRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\File;
use Symfony\Component\HttpFoundation\Response as HTTPResponse;


use function App\upload_asset_file;

class AboutController extends Controller
{
    private InterfaceAboutRepository $interfaceAboutRepository;
    public function __construct(InterfaceAboutRepository $interfaceAboutRepository)
    {
        $this->interfaceAboutRepository = $interfaceAboutRepository;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(AboutRequest $request):AnonymousResourceCollection
    {
        $count = @$request->count ?? 10;
        $title = @$request->title;
        $description = @$request->description;

        $abouts = $this->interfaceAboutRepository->query();
        if (@$title)
            $abouts = $abouts->whereTitle($title);
        if (@$description)
            $abouts = $abouts->whereDescription($description);
        return AboutResource::collection($abouts->paginate($count));
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
    public function store(StoreAboutRequest $request):JsonResponse
    {
        $data = $request->except(['_token']);
        $data['image'] = upload_asset_file($request->file('image'), 'abouts');
        if ($this->interfaceAboutRepository->insertData($data))
            return response()->json(['message' => 'successfully your transaction!'], HTTPResponse::HTTP_OK);
        return response()->json(['message' => 'sorry, your transaction fails!'], HTTPResponse::HTTP_BAD_REQUEST);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id):AboutResource
    {
        return AboutResource::make($this->interfaceAboutRepository->findById($id));
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
    public function update(UpdateAboutRequest $request, int $id):JsonResponse
    {
        $data=$request->except(["_token"]);
        if($request->hasFile('image')){
           $image_url=$this->interfaceAboutRepository->findById($id)['image'];
           \File::delete(public_path($image_url));
            $data['image']= upload_asset_file($request->file('image'),'abouts');
        }
        if ($this->interfaceAboutRepository->updateItem($id,$data))
            return response()->json(['message' => 'successfully your transaction!'], HTTPResponse::HTTP_OK);
          return response()->json(['message' => 'sorry, your transaction fails!'], HTTPResponse::HTTP_BAD_REQUEST);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id):JsonResponse
    {
        $image_url=$this->interfaceAboutRepository->findById($id)['image'];
     
        \File::delete(public_path($image_url));
       
         if($this->interfaceAboutRepository->deleteData($id))
             return response()->json(['message' => 'successfully your transaction!'], HTTPResponse::HTTP_OK);
           return response()->json(['message' => 'sorry, your transaction fails!'], HTTPResponse::HTTP_BAD_REQUEST);
    }
}
