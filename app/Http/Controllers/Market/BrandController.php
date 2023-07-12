<?php

namespace App\Http\Controllers\Market;

use App\Http\Controllers\Controller;
use App\Http\Requests\brand\BrandRequest;
use App\Http\Requests\brand\StoreBrandRequest;
use App\Http\Requests\brand\UpdateBrandRequest;
use App\Http\Resources\brand\BrandResource;
use App\Models\Market\Brand;
use App\Repositories\MySQL\BrandRepository\InterfaceBrandRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Symfony\Component\HttpFoundation\Response as HTTPResponse;
use function App\upload_asset_file;

class BrandController extends Controller
{

    private  InterfaceBrandRepository $interfaceBrandRepository;

    public function __construct(InterfaceBrandRepository $interfaceBrandRepository)
    {
        $this->interfaceBrandRepository=$interfaceBrandRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(BrandRequest $request):AnonymousResourceCollection
    {
        $brands=$this->interfaceBrandRepository->query();
        $count=@$request->count ?? 10;
        $persian_name=@$request->persian_name;
        $original_name=@$request->original_name;
        if(@$persian_name)
            $brands=$brands->wherePersianName($persian_name);
        if(@$original_name)
            $brands=$brands->whereOriginalName($original_name);
        $brands=$brands->paginate($count);

            return BrandResource::collection($brands);


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
    public function store(StoreBrandRequest $request):JsonResponse
    {
        $data=$request->except(['_token']);
        $result =upload_asset_file($request->file('logo'),'brands');
        $data['logo']="brands/".$result;
        if($this->interfaceBrandRepository->insertData($data))
            return response()->json(['message' => 'successfully your transaction!'], HTTPResponse::HTTP_OK);
        return response()->json(['message' => 'sorry, your transaction fails!'], HTTPResponse::HTTP_BAD_REQUEST);
    }

    /**
     * Display the specified resource.
     */
    public function show(int  $id):BrandResource
    {
        return BrandResource::make($this->interfaceBrandRepository->findById($id))   ;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Brand $brand)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBrandRequest $request, int $id):JsonResponse
    {
        $data=$request->except(['_token']);
       if( $request->file('logo')){
           $result =upload_asset_file($request->file('logo'),'brands');
           \File::delete($this->interfaceBrandRepository->findById($id)['logo']);
           $data['logo']="brands/".$result;
           $result=$this->interfaceBrandRepository->updateItem($id,$data);
           return response()->json(['message' => 'successfully your transaction!'], HTTPResponse::HTTP_OK);
       }

       if ($this->interfaceBrandRepository->updateItem($id,$data))
             return response()->json(['message' => 'successfully your transaction!'], HTTPResponse::HTTP_OK);

           return response()->json(['message' => 'sorry, your transaction fails!'], HTTPResponse::HTTP_BAD_REQUEST);




    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        if($this->interfaceBrandRepository->deleteData($id))
            return response()->json(['message' => 'successfully your transaction!'], HTTPResponse::HTTP_OK);
        return response()->json(['message' => 'sorry, your transaction fails!'], HTTPResponse::HTTP_BAD_REQUEST);
    }
}
