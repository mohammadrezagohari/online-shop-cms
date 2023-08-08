<?php

namespace App\Http\Controllers;

use App\Http\Requests\user\StoreUserRequest;
use App\Http\Requests\user\UpdateUserRequest;
use App\Http\Requests\user\UserRequest;
use App\Http\Resources\user\UserResource;
use App\Models\User;
use App\Repositories\MySQL\UserRepository\InterfaceUserRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Symfony\Component\HttpFoundation\Response as HTTPResponse;
use function Sodium\add;

/**
 * @group User
 *
 *API endpoints for User Services
 *
 *
 */
class UserController extends Controller
{


    private InterfaceUserRepository $interfaceUserRepository;

    public function __construct(InterfaceUserRepository $interfaceUserRepository)
    {
        $this->interfaceUserRepository = $interfaceUserRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(UserRequest $request): AnonymousResourceCollection
    {
        $count = @$request->count ?? 10;
        $mobile = @$request->mobile;
        $national_code = @$request->national_code;
        $first_name = @$request->first_name;
        $last_name = @$request->last_name;
        $user_type = @$request->user_type;
        $status = @$request->status;

        $users = $this->interfaceUserRepository->query();

        if (@$mobile)
            $users = $users->whereMobile(@$mobile);
        if (@$national_code)
            $users = $users->whereNationalCode(@$national_code);
        if (@$first_name)
            $users = $users->whereFirstName(@$first_name);
        if (@$last_name)
            $users = $users->whereLastName(@$last_name);
        if (@$user_type)
            $users = $users->whereUserType(@$user_type);
        if (@$status != null)
            $users = $users->whereStatus(@$status);

        return UserResource::collection($users->paginate($count));


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
    public function store(StoreUserRequest $request)
    {
        $data = $request->except(['_token']);
        if ($this->interfaceUserRepository->insertData($data))
            return response()->json(['message' => 'successfully your transaction!'], HTTPResponse::HTTP_OK);
        return response()->json(['message' => 'sorry, your transaction fails!'], HTTPResponse::HTTP_BAD_REQUEST);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id): UserResource
    {
        return UserResource::make($this->interfaceUserRepository->findById($id));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, int $id): JsonResponse
    {
        $data = $request->except(['_token']);
        if ($this->interfaceUserRepository->updateItem($id, $data))
            return response()->json(['message' => 'successfully your transaction!'], HTTPResponse::HTTP_OK);
        return response()->json(['message' => 'sorry, your transaction fails!'], HTTPResponse::HTTP_BAD_REQUEST);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id): JsonResponse
    {
        if ($this->interfaceUserRepository->deleteData($id))
            return response()->json(['message' => 'successfully your transaction!'], HTTPResponse::HTTP_OK);
        return response()->json(['message' => 'sorry, your transaction fails!'], HTTPResponse::HTTP_BAD_REQUEST);
    }


    public function assignRole(Request $request): JsonResponse
    {
        $validation = \Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'role_id' => 'required|exists:roles,id'
        ]);

        if ($validation->fails())
            return response()->json([
                'message' => $validation->messages(),
                'status' => false,
            ], HTTPResponse::HTTP_OK);


        $user = $this->interfaceUserRepository->findById($request->user_id);

        $role = Role::where('id', '=', $request->role_id)->pluck('name');

        if ($user->assignRole($role))
            return response()->json(['message' => 'successfully your transaction!'], HTTPResponse::HTTP_OK);
        return response()->json(['message' => 'sorry, your transaction fails!'], HTTPResponse::HTTP_BAD_REQUEST);
    }

    public function assignPermissionToRole(Request $request): JsonResponse
    {
        $validation = \Validator::make($request->all(), [
            'permission_id' => 'required|exists:permissions,id',
            'role_id' => 'required|exists:roles,id'
        ]);
        $data = $request->except(['_token']);

        if ($validation->fails())
            return response()->json([
                'message' => $validation->messages(),
                'status' => false,
            ], HTTPResponse::HTTP_OK);
        $permission = Permission::find($data['permission_id']);
        $role = Role::where('id', '=', $request->role_id)->first();

        if ($role->givePermissionTo($permission))
            return response()->json(['message' => 'successfully your transaction!'], HTTPResponse::HTTP_OK);
        return response()->json(['message' => 'sorry, your transaction fails!'], HTTPResponse::HTTP_BAD_REQUEST);
    }


    public function assignPermission(Request $request): JsonResponse
    {
        $validation = \Validator::make($request->all(), [
            'permission_id' => 'required|exists:permissions,id',
            'user_id' => 'required|exists:users,id'
        ]);

        if ($validation->fails())
            return response()->json([
                'message' => $validation->messages(),
                'status' => false,
            ], HTTPResponse::HTTP_OK);
        $permission = Permission::find($request->permission_id);
        $user = User::find($request->user_id);

        if ($user->givePermissionTo($permission))
            return response()->json(['message' => 'successfully your transaction!'], HTTPResponse::HTTP_OK);
        return response()->json(['message' => 'sorry, your transaction fails!'], HTTPResponse::HTTP_BAD_REQUEST);
    }


    public function hasRole(Request $request): JsonResponse
    {
        $validation = \Validator::make($request->all(), [
            'role_id' => 'required|exists:roles,id',
            'user_id' => 'required|exists:users,id'
        ]);

        if ($validation->fails())
            return response()->json([
                'message' => $validation->messages(),
                'status' => false,
            ], HTTPResponse::HTTP_OK);
        $user = User::find($request->user_id);
        $role = Role::findById($request->role_id);
        if ($user->hasRole($role))
            return response()->json(['message' => 'yes,this user has role'], HTTPResponse::HTTP_OK);
        return response()->json(['message' => 'no , this user has not role!'], HTTPResponse::HTTP_BAD_REQUEST);
    }

//send data $role[0],prev line $role[1]
    public function hasAnyRole(Request $request): JsonResponse
    {
        $validation = \Validator::make($request->all(), [
            'roles.*' => 'required|exists:roles,id',
            'user_id' => 'required|exists:users,id'
        ]);

        if ($validation->fails())
            return response()->json([
                'message' => $validation->messages(),
                'status' => false,
            ], HTTPResponse::HTTP_OK);

        $user = User::find($request->user_id);
        $roles = [];
        foreach ($request->roles as $key => $value) {

            $role = Role::find((int)$value)['name'];
            array_push($roles, $role);

        }
        if ($user->hasAnyRole($roles))
            return response()->json(['message' => 'yes,this user has any role'], HTTPResponse::HTTP_OK);
        return response()->json(['message' => 'no , this user has not any role!'], HTTPResponse::HTTP_BAD_REQUEST);
    }

    public function hasAllRoles(Request $request): JsonResponse
    {
        $validation = \Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id'
        ]);

        if ($validation->fails())
            return response()->json([
                'message' => $validation->messages(),
                'status' => false,
            ], HTTPResponse::HTTP_OK);

        $user = User::find($request->user_id);
        if ($user->hasAllRoles(Role::all()))
            return response()->json(['message' => 'yes,this user has all role'], HTTPResponse::HTTP_OK);
        return response()->json(['message' => 'no , this user has not all role!'], HTTPResponse::HTTP_BAD_REQUEST);
    }

    public function removeRole(Request $request): JsonResponse
    {
        $validation = \Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'role_id' => 'required|exists:roles,id'
        ]);

        if ($validation->fails())
            return response()->json([
                'message' => $validation->messages(),
                'status' => false,
            ], HTTPResponse::HTTP_OK);
        $user = User::find($request->user_id);
        $role = Role::find($request->role_id);

        if ($user->removeRole($role))
            return response()->json(['message' => 'you are transaction successfully'], HTTPResponse::HTTP_OK);
        return response()->json(['message' => 'your  transaction failed!'], HTTPResponse::HTTP_BAD_REQUEST);
    }


    public function hasDirectPermission(Request $request): JsonResponse
    {
        $validation = \Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'permission_id' => 'required|exists:permissions,id'
        ]);

        if ($validation->fails())
            return response()->json([
                'message' => $validation->messages(),
                'status' => false,
            ], HTTPResponse::HTTP_OK);


        $user = User::find($request->user_id);
        $permission = Permission::find($request->permission_id);

        if ($user->hasDirectPermission($permission))
            return response()->json(['message' => 'yes this user has direct permission'], HTTPResponse::HTTP_OK);
        return response()->json(['message' => 'no this user has not direct permission!'], HTTPResponse::HTTP_BAD_REQUEST);
    }


    public function hasAllDirectPermissions(Request $request): JsonResponse
    {
        $validation = \Validator::make($request->all(), [
            'permissions.*' => 'required|exists:permissions,id',
            'user_id' => 'required|exists:users,id'
        ]);

        if ($validation->fails())
            return response()->json([
                'message' => $validation->messages(),
                'status' => false,
            ], HTTPResponse::HTTP_OK);

        $user = User::find($request->user_id);

        $permissions = [];
        foreach ($request->permissions as $key => $value) {
            $permission = Permission::find((int)$value)['name'];
            array_push($permissions, $permission);
        }
        if ($user->hasAllDirectPermissions($permissions))
            return response()->json(['message' => 'yes this user has all direct permission'], HTTPResponse::HTTP_OK);
        return response()->json(['message' => 'no this user has not all direct permission!'], HTTPResponse::HTTP_BAD_REQUEST);
    }


    public function hasAnyDirectPermission(Request $request)
    {
        $validation = \Validator::make($request->all(), [
            'permissions.*' => 'required|exists:permissions,id',
            'user_id' => 'required|exists:users,id'
        ]);

        if ($validation->fails())
            return response()->json([
                'message' => $validation->messages(),
                'status' => false,
            ], HTTPResponse::HTTP_OK);

        $user = User::find($request->user_id);

        $permissions = [];
        foreach ($request->permissions as $key => $value) {
            $permission = Permission::find((int)$value)['name'];
            array_push($permissions, $permission);
        }
        if ($user->hasAnyDirectPermission($permissions))
            return response()->json(['message' => 'yes this user has all direct permission'], HTTPResponse::HTTP_OK);
        return response()->json(['message' => 'no this user has not all direct permission!'], HTTPResponse::HTTP_BAD_REQUEST);
    }


    public function getDirectPermissions(Request $request)
    {
        $validation = \Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id'
        ]);

        if ($validation->fails())
            return response()->json([
                'message' => $validation->messages(),
                'status' => false,
            ], HTTPResponse::HTTP_OK);

        $user = User::find($request->user_id);
        $permissions = $user->getDirectPermissions();
        return response()->json(['data' => $permissions], HTTPResponse::HTTP_OK);
    }


    public function revokePermissionFromRole(Request $request): JsonResponse
    {
        $validation = \Validator::make($request->all(), [
            'permission_id' => 'required|exists:permissions,id',
            'role_id' => 'required|exists:roles,id',

        ]);

        if ($validation->fails())
            return response()->json([
                'message' => $validation->messages(),
                'status' => false,
            ], HTTPResponse::HTTP_OK);
        $role = Role::findById($request->role_id);
        $permission = Permission::find($request->permission_id);
        if ($role->revokePermissionTo($permission))
            return response()->json(['message' => 'successfully your transaction '], HTTPResponse::HTTP_OK);
        return response()->json(['message' => 'sorry your transaction failed!'], HTTPResponse::HTTP_BAD_REQUEST);
    }

    public function permissionsForRole(Request $request)
    {
        $validation = \Validator::make($request->all(), [
            'role_id' => 'required|exists:roles,id',
        ]);

        if ($validation->fails())
            return response()->json([
                'message' => $validation->messages(),
                'status' => false,
            ], HTTPResponse::HTTP_OK);

        $role = Role::findById($request->role_id);

        return response()->json(['data' => $role->permissions], HTTPResponse::HTTP_OK);

    }


}
