<?php

namespace App\Http\Controllers;

use App\Http\Requests\aboutAttachment\AboutAttachmentRequest;
use App\Http\Requests\aboutAttachment\StoreAboutAttachmentRequest;
use App\Http\Requests\aboutAttachment\UpdateAboutAttachmentRequest;
use App\Http\Resources\aboutAttachment\AboutAttachmentResource;
use App\Models\AboutAttachment;
use App\Repositories\MySQL\AboutAttachmentRepository\InterfaceAboutAttachmentRepository;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response as HTTPResponse;


use function App\upload_asset_file;

class AboutAttachmentController extends Controller
{
    private InterfaceAboutAttachmentRepository $interfaceAboutAttachmentRepository;
    public function __construct(InterfaceAboutAttachmentRepository $interfaceAboutAttachmentRepository)
    {
        $this->interfaceAboutAttachmentRepository = $interfaceAboutAttachmentRepository;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(AboutAttachmentRequest $request)
    {
        $count = @$request->count ?? 10;
        $title = @$request->title;
        $about_id = @$request->about_id;

        $aboutAttachments = $this->interfaceAboutAttachmentRepository->query();
        if (@$title)
            $aboutAttachments = $aboutAttachments->whereTitle($title);
        if (@$about_id)
            $aboutAttachments = $aboutAttachments->whereAboutId($about_id);
        return AboutAttachmentResource::collection($aboutAttachments->paginate($count));
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
    public function store(StoreAboutAttachmentRequest $request)
    {
        $data = $request->except(['_token']);
        $data['icon'] = upload_asset_file($request->file('icon'), "about-attachment");
        if ($this->interfaceAboutAttachmentRepository->insertData($data))
            return response()->json(['message' => 'successfully your transaction!'], HTTPResponse::HTTP_OK);
        return response()->json(['message' => 'sorry, your transaction fails!'], HTTPResponse::HTTP_BAD_REQUEST);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        return AboutAttachmentResource::make($this->interfaceAboutAttachmentRepository->findById($id));
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
    public function update(UpdateAboutAttachmentRequest $request, int $id)
    {
        $data=$request->except(["_token"]);
        if($request->hasFile('icon')){
           $image_url=$this->interfaceAboutAttachmentRepository->findById($id)['icon'];
           \File::delete(public_path($image_url));
            $data['icon']= upload_asset_file($request->file('icon'),'about-attachment');
        }
        if ($this->interfaceAboutAttachmentRepository->updateItem($id,$data))
            return response()->json(['message' => 'successfully your transaction!'], HTTPResponse::HTTP_OK);
          return response()->json(['message' => 'sorry, your transaction fails!'], HTTPResponse::HTTP_BAD_REQUEST);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        $image_url=$this->interfaceAboutAttachmentRepository->findById($id)['icon'];
     
        \File::delete(public_path($image_url));
       
         if($this->interfaceAboutAttachmentRepository->deleteData($id))
             return response()->json(['message' => 'successfully your transaction!'], HTTPResponse::HTTP_OK);
           return response()->json(['message' => 'sorry, your transaction fails!'], HTTPResponse::HTTP_BAD_REQUEST);
    }
}
