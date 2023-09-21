<?php

namespace App\Http\Controllers;

use App\Http\Requests\condition\ConditionRequest;
use App\Http\Requests\condition\StoreConditionRequest;
use App\Http\Requests\condition\UpdateConditionRequest;
use App\Http\Resources\condition\ConditionResource;
use App\Repositories\MySQL\ConditionRepository\InterfaceConditionRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Resources\Json\JsonResource;
use Symfony\Component\HttpFoundation\Response as HTTPResponse;
use function App\upload_asset_file;

class ConditionController extends Controller
{


    private InterfaceConditionRepository $interfaceConditionRepository;

    public function __construct(InterfaceConditionRepository $interfaceConditionRepository)
    {
        $this->interfaceConditionRepository = $interfaceConditionRepository;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(ConditionRequest $request):AnonymousResourceCollection
    {
        $conditions = $this->interfaceConditionRepository->query();
        $count = @$request->count ?? 10;
        $title = @$request->title;
        $status = @$request->status;
        if (@$title)
            $conditions = $conditions->whereTitle($title);
        if (@$status != null)
            $conditions = $conditions->wherestatus($status);

        return ConditionResource::collection($conditions->paginate($count));
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
    public function store(StoreConditionRequest $request):JsonResponse
    {
        $data = $request->except(['_token']);
        $data['icon'] = upload_asset_file($request->file('icon'), 'condition');
        if ($this->interfaceConditionRepository->insertData($data))
            return response()->json(['message' => 'successfully your transaction!'], HTTPResponse::HTTP_OK);
        return response()->json(['message' => 'sorry, your transaction fails!'], HTTPResponse::HTTP_BAD_REQUEST);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id):ConditionResource
    {
        return ConditionResource::make($this->interfaceConditionRepository->findById($id));
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
    public function update(UpdateConditionRequest $request, int $id):JsonResponse
    {
        
        $data=$request->except(['_token']);
        if( $request->hasFile('icon')){
            $data['icon'] =upload_asset_file($request->file('icon'),'condition');
            \File::delete($this->interfaceConditionRepository->findById($id)['icon']);
        }
 
        if ($this->interfaceConditionRepository->updateItem($id,$data))
              return response()->json(['message' => 'successfully your transaction!'], HTTPResponse::HTTP_OK);
            return response()->json(['message' => 'sorry, your transaction fails!'], HTTPResponse::HTTP_BAD_REQUEST);
 
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id):JsonResponse
    {
        $image_url=$this->interfaceConditionRepository->findById($id)['icon'];
     
        \File::delete(public_path($image_url));
       
        if($this->interfaceConditionRepository->deleteData($id))
            return response()->json(['message' => 'successfully your transaction!'], HTTPResponse::HTTP_OK);
        return response()->json(['message' => 'sorry, your transaction fails!'], HTTPResponse::HTTP_BAD_REQUEST);
    }
}
