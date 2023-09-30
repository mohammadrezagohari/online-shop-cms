<?php

namespace App\Http\Controllers\Market;

use App\Http\Controllers\Controller;
use App\Http\Requests\userFavoritesUser\DeleteUserFavoritesUserRequest;
use App\Http\Requests\userFavoritesUser\StoreUserFavoritesUserRequest;
use App\Http\Requests\userFavoritesUser\UserFavoritesUserRequest;
use App\Http\Resources\resource\ProductResource;
use App\Models\Market\Product;
use App\Models\User;
use Symfony\Component\HttpFoundation\Response as HTTPResponse;
use App\Repositories\MySQL\ProductRepository\InterfaceProductRepository;
use App\Repositories\MySQL\UserRepository\InterfaceUserRepository;
use Illuminate\Http\Request;

class UserFavoritesProductController extends Controller
{
    private InterfaceUserRepository $interfaceUserRepository;
    private InterfaceProductRepository $interfaceProductRepository;

    public function __construct(InterfaceUserRepository $interfaceUserRepository, InterfaceProductRepository $interfaceProductRepository)
    {
        $this->interfaceUserRepository = $interfaceUserRepository;
        $this->interfaceProductRepository = $interfaceProductRepository;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(UserFavoritesUserRequest $request)
    {
        
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
    public function store(StoreUserFavoritesUserRequest $request, int $id)
    {
        $user = $this->interfaceUserRepository->findById($id);
        $product = $this->interfaceProductRepository->findById($request->product_id);

        if (!$user->products()->attach($product))
            return response()->json(['message' => 'successfully your transaction!'], HTTPResponse::HTTP_OK);
        return response()->json(['message' => 'sorry, your transaction fails!'], HTTPResponse::HTTP_BAD_REQUEST);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        $user = $this->interfaceUserRepository->findById($id);
        return ProductResource::collection($user->products);
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
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DeleteUserFavoritesUserRequest $request ,int $id)
    {
        
        
        $user = $this->interfaceUserRepository->findById($id);
        $product = $this->interfaceProductRepository->findById($request->product_id);

        if ($user->products()->detach($product))
            return response()->json(['message' => 'successfully your transaction!'], HTTPResponse::HTTP_OK);
        return response()->json(['message' => 'sorry, your transaction fails!'], HTTPResponse::HTTP_BAD_REQUEST);
    }
}
