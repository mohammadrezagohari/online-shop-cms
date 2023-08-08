<?php

namespace App\Http\Controllers;

use App\Repositories\MySQL\RoleRepository\InterfaceRoleRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Symfony\Component\HttpFoundation\Response as HTTPResponse;

class RoleController extends Controller
{

    private InterfaceRoleRepository $interfaceRoleRepository;

    public function __construct(InterfaceRoleRepository $interfaceRoleRepository)
    {

        $this->interfaceRoleRepository = $interfaceRoleRepository;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return  $this->interfaceRoleRepository->getAll();
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
        $validation = \Validator::make($request->only('role'), [
            'role' => 'required|string|min:3|max:255'
        ]);
        if ($validation->fails())
            return response()->json([
                'message' => $validation->messages(),
                'status' => false,
            ], HTTPResponse::HTTP_OK);
        try {
            Role::create(['name' => $request->input('role'),'guard_name'=>'web']);
            return response()->json(['message' => 'successfully your transaction!'], HTTPResponse::HTTP_OK);

        } catch (\Exception $exception) {
            return response()->json(['message' => 'sorry, your transaction fails because role is taken!'], HTTPResponse::HTTP_BAD_REQUEST);

        }

    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
       return $this->interfaceRoleRepository->findById($id);
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
    public function update(Request $request, int $id):JsonResponse
    {
        $validation = \Validator::make($request->only('role'), [
            'role' => 'required|string|min:3|max:255'
        ]);
        if ($validation->fails())
            return response()->json([
                'message' => $validation->messages(),
                'status' => false,
            ], HTTPResponse::HTTP_OK);
            if($this->interfaceRoleRepository->updateItem($id,[
                'name'=>$request->input('role'),
            ]))
                return response()->json(['message' => 'successfully your transaction!'], HTTPResponse::HTTP_OK);
        return response()->json(['message' => 'sorry, your transaction fails!'], HTTPResponse::HTTP_BAD_REQUEST);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id):JsonResponse
    {
      if($this->interfaceRoleRepository->deleteData($id))
          return response()->json(['message' => 'successfully your transaction!'], HTTPResponse::HTTP_OK);
        return response()->json(['message' => 'sorry, your transaction fails!'], HTTPResponse::HTTP_BAD_REQUEST);

    }
}
