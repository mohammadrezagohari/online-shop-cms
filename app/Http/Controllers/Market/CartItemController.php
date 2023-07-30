<?php

namespace App\Http\Controllers\Market;

use App\Http\Controllers\Controller;
use App\Http\Requests\cartItem\CartItemRequest;
use App\Http\Requests\cartItem\StoreCartItemRequest;
use App\Http\Requests\cartItem\UpdateCartItemRequest;
use App\Http\Resources\cartItem\CartItemResource;
use App\Models\Market\CartItem;
use App\Repositories\MySQL\CartItemRepository\InterfaceCartItemRepository;
use http\Env\Response;
use Illuminate\Http\Client\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Symfony\Component\HttpFoundation\Response as HTTPResponse;
/**
 * @group CartItem
 *
 *API endpoints for CartItem Services
 *
 *
 */
class CartItemController extends Controller
{
    private InterfaceCartItemRepository $interfaceCartItemRepository;

    public function __construct(InterfaceCartItemRepository $interfaceCartItemRepository)
    {
        $this->interfaceCartItemRepository = $interfaceCartItemRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(CartItemRequest $request):AnonymousResourceCollection
    {
        $count = @$request->count ?? 10;
        $user_id = @$request->user_id;
        $product_id = @$request->product_id;
        $color_id = @$request->color_id;
        $guarantee_id = @$request->guarantee_id;
        $cartItems = $this->interfaceCartItemRepository->query();

        if (@$user_id)
            $cartItems = $cartItems->whereUserId($user_id);
        if (@$product_id)
            $cartItems = $cartItems->whereProductId($product_id);
        if (@$color_id)
            $cartItems = $cartItems->whereColorId($color_id);
        if (@$guarantee_id)
            $cartItems = $cartItems->whereGuarantee($product_id);

        $cartItems = $cartItems->paginate($count);
        return CartItemResource::collection($cartItems);


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
    public function store(StoreCartItemRequest $request):JsonResponse
    {
        $data = $request->except(['_token']);
        if ($this->interfaceCartItemRepository->insertData($data))
            return response()->json(['message' => 'successfully your transaction!'], HTTPResponse::HTTP_OK);
        return response()->json(['message' => 'sorry, your transaction fails!'], HTTPResponse::HTTP_BAD_REQUEST);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id):CartItemResource
    {
        return CartItemResource::make($this->interfaceCartItemRepository->findById($id));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CartItem $cartItem)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCartItemRequest $request, int $id):JsonResponse
    {
        $data=$request->except(['_token']);
        if($this->interfaceCartItemRepository->updateItem($id,$data))
            return response()->json(['message' => 'successfully your transaction!'], HTTPResponse::HTTP_OK);
        return response()->json(['message' => 'sorry, your transaction fails!'], HTTPRespornse::HTTP_BAD_REQUEST);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id):JsonResponse
    {
        if($this->interfaceCartItemRepository->deleteData($id))
            return response()->json(['message' => 'successfully your transaction!'], HTTPResponse::HTTP_OK);
        return response()->json(['message' => 'sorry, your transaction fails!'], HTTPRespornse::HTTP_BAD_REQUEST);
    }
}
