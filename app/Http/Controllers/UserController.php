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
}
