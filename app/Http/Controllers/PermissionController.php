<?php

namespace App\Http\Controllers;

use App\Repositories\MySQL\PermissionRepository\InterfacePermissionRepository;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Symfony\Component\HttpFoundation\Response as HTTPResponse;

class PermissionController extends Controller
{

    private InterfacePermissionRepository $interfacePermissionRepository;

    public function __construct(InterfacePermissionRepository $interfacePermissionRepository)
    {
        $this->interfacePermissionRepository = $interfacePermissionRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->interfacePermissionRepository->getAll();
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
    public function store(Request $request)
    {
        $validation = \Validator::make($request->only('permission'), [
            'permission' => 'required|string|min:3|max:255'
        ]);

        if ($validation->fails())
            return response()->json([
                'message' => $validation->messages(),
                'status' => false,
            ], HTTPResponse::HTTP_OK);
        try {
            Permission::create(['name' => $request->input('permission'),'guard_name'=>'web']);
            return response()->json(['message' => 'successfully your transaction!'], HTTPResponse::HTTP_OK);

        } catch (\Exception $exception) {
            return response()->json(['message' => 'sorry, your transaction fails because permission is taken!'], HTTPResponse::HTTP_BAD_REQUEST);

        }

    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        return $this->interfacePermissionRepository->findById($id);
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
    public function update(Request $request, int $id)
    {
        $validation = \Validator::make($request->only('permission'), [
            'permission' => 'required|string|min:3|max:255'
        ]);

        if ($validation->fails())
            return response()->json([
                'message' => $validation->messages(),
                'status' => false,
            ], HTTPResponse::HTTP_OK);
        if($this->interfacePermissionRepository->updateItem($id,['name'=>$request->input('permission')]))
            return response()->json(['message' => 'successfully your transaction!'], HTTPResponse::HTTP_OK);
        return response()->json(['message' => 'sorry, your transaction fails!'], HTTPResponse::HTTP_BAD_REQUEST);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        if($this->interfacePermissionRepository->deleteData($id))
            return response()->json(['message' => 'successfully your transaction!'], HTTPResponse::HTTP_OK);
        return response()->json(['message' => 'sorry, your transaction fails!'], HTTPResponse::HTTP_BAD_REQUEST);
    }
}
