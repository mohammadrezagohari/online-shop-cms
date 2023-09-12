<?php

namespace App\Http\Controllers\Market;

use App\Http\Controllers\Controller;
use App\Http\Requests\banner\BannerRequest;
use App\Http\Requests\banner\StoreBannerRequest;
use App\Http\Requests\banner\UpdateBannerRequest;
use App\Http\Resources\banner\BannerResource;
use App\Repositories\MySQL\BannerRepository\InterfaceBannerRepository;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Symfony\Component\HttpFoundation\Response as HTTPResponse;
use function App\upload_asset_file;


class BannerController extends Controller
{
    private InterfaceBannerRepository $interfaceBannerRepository;
    public function __construct(InterfaceBannerRepository $interfaceBannerRepository)
    {
        $this->interfaceBannerRepository=$interfaceBannerRepository;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(BannerRequest $request):AnonymousResourceCollection
    {        

        $banners=$this->interfaceBannerRepository->query();
        $count=@$request->count ?? 10;
        $title=@$request->title;
        $status=@$request->status;
        if(@$title)
           $banners=$banners->whereTitle($title);
      

        if(@$status!=null)
            $banners=$banners->whereStatus($status);

            return BannerResource::collection($banners->paginate($count));
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
    public function store(StoreBannerRequest $request)
    {
        $data=$request->except(['_token']);
        $image=upload_asset_file($request->file('image'),'banner');
        $data['image']=$image;
  
        if($this->interfaceBannerRepository->insertData($data))
            return response()->json(['message' => 'successfully your transaction!'], HTTPResponse::HTTP_OK);
          return response()->json(['message' => 'sorry, your transaction fails!'], HTTPResponse::HTTP_BAD_REQUEST);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        return BannerResource::make($this->interfaceBannerRepository->findById($id));
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
    public function update(UpdateBannerRequest $request, int $id)
    {
        $data=$request->except(["_token"]);
      if($request->hasFile('image')){
         $image_url=$this->interfaceBannerRepository->findById($id)['image'];
         \File::delete(public_path($image_url));
          $data['image']= upload_asset_file($request->file('image'),'banner');
      }
      if ($this->interfaceBannerRepository->updateItem($id,$data))
          return response()->json(['message' => 'successfully your transaction!'], HTTPResponse::HTTP_OK);
        return response()->json(['message' => 'sorry, your transaction fails!'], HTTPResponse::HTTP_BAD_REQUEST);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        
       $image_url=$this->interfaceBannerRepository->findById($id)['image'];
     
       \File::delete(public_path($image_url));
      
        if($this->interfaceBannerRepository->deleteData($id))
            return response()->json(['message' => 'successfully your transaction!'], HTTPResponse::HTTP_OK);
          return response()->json(['message' => 'sorry, your transaction fails!'], HTTPResponse::HTTP_BAD_REQUEST);
  
    }
}
