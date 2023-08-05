<?php

namespace App\Http\Controllers\Market;

use App\Http\Controllers\Controller;
use App\Http\Requests\cartItem\CartItemRequest;
use App\Http\Requests\cartItem\StoreCartItemRequest;
use App\Http\Requests\cartItem\UpdateCartItemRequest;
use App\Http\Requests\productCategory\StoreProductCategoryRequest;
use App\Http\Resources\cartItem\CartItemResource;
use App\Models\Market\CartItem;
use App\Models\Market\Order;
use App\Repositories\MySQL\CartItemRepository\InterfaceCartItemRepository;
use App\Repositories\MySQL\ProductColorRepository\InterfaceProductColorRepository;
use App\Repositories\MySQL\ProductRepository\InterfaceProductRepository;
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
    private InterfaceProductRepository $interfaceProductRepository;
    private InterfaceProductColorRepository $interfaceProductColorRepository;

    public function __construct(InterfaceCartItemRepository     $interfaceCartItemRepository,
                                InterfaceProductRepository      $interfaceProductRepository,
                                InterfaceProductColorRepository $interfaceProductColorRepository
    )
    {
        $this->interfaceCartItemRepository = $interfaceCartItemRepository;
        $this->interfaceProductRepository = $interfaceProductRepository;
        $this->interfaceProductColorRepository = $interfaceProductColorRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(CartItemRequest $request): AnonymousResourceCollection
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
    public function store(StoreCartItemRequest $request)
    {
        $data = $request->except(['_token']);
        $query = $this->interfaceCartItemRepository->query();
        $product = $this->interfaceProductRepository->findById($data['product_id']);

        //user has cart items
        if ($cartItems = $this->interfaceCartItemRepository->findByUserId($data['user_id'])) {
            foreach ($cartItems as $cartItem) {
                if ($cartItem['product_id'] == $data['product_id']) {
                    if ($result = $query->where('color_id', '=', $data['color_id'])->where('guarantee_id', '=', $data['guarantee_id'])->first()) {
                        if (isset($data['color_id'])) {
                            $productColorSelect = $this->interfaceProductColorRepository->findById($data['color_id']);
                            if ($data['number'] > $productColorSelect['marketable_number']) {
                                return response()->json(['message' => 'sorry, The number of your purchase is more than the inventory!'], HTTPResponse::HTTP_BAD_REQUEST);
                            } else {
                                $this->interfaceProductColorRepository->updateItem($data['color_id'], [
                                    'marketable_number' => $productColorSelect['marketable_number'] - $data['number'],
                                    'frozen_number' => $productColorSelect['frozen_number'] + $data['number'],

                                ]);
                                if ($this->interfaceCartItemRepository->updateItem($result['id'], [
                                    'number' => $result['number'] + $data['number'],
                                ]))
                                    return response()->json(['message' => 'successfully your transaction!'], HTTPResponse::HTTP_OK);
                                return response()->json(['message' => 'sorry, your transaction fails!'], HTTPResponse::HTTP_BAD_REQUEST);


                            }
                        }
                        if ($data['number'] > $product['marketable_number']) {
                            return response()->json(['message' => 'sorry, The number of your purchase is more than the inventory!'], HTTPResponse::HTTP_BAD_REQUEST);
                        } else {

                            //update number of marketable and frozen
                            $this->interfaceProductRepository->updateItem($data['product_id'], [
                                'marketable_number' => $product['marketable_number'] - $data['number'],
                                'frozen_number' => $product['frozen_number'] + $data['number'],

                            ]);


                            if ($this->interfaceCartItemRepository->updateItem($result['id'], [
                                'number' => $result['number'] + $data['number'],
                            ]))
                                return response()->json(['message' => 'successfully your transaction!'], HTTPResponse::HTTP_OK);
                            return response()->json(['message' => 'sorry, your transaction fails!'], HTTPResponse::HTTP_BAD_REQUEST);

                        }
                    }

                }

            }
            //when product id not equal cart item eql
            //number bigger than to marketable number

        }
        if ($data['number'] > $product['marketable_number']) {
            return response()->json(['message' => 'sorry, The number of your purchase is more than the inventory!'], HTTPResponse::HTTP_BAD_REQUEST);
        } else {
            //update number of marketable and frozen
            $this->interfaceProductRepository->updateItem($data['product_id'], [
                'marketable_number' => $product['marketable_number'] - $data['number'],
                'frozen_number' => $product['frozen_number'] + $data['number'],

            ]);
            //insert data to cart items
            if ($this->interfaceCartItemRepository->insertData($data))
                return response()->json(['message' => 'successfully your transaction!'], HTTPResponse::HTTP_OK);
            return response()->json(['message' => 'sorry, your transaction fails!'], HTTPResponse::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id): CartItemResource
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
    public function update(UpdateCartItemRequest $request, int $id): JsonResponse
    {
        $data = $request->only(['number']);
        $cartItem = $this->interfaceCartItemRepository->findById($id);


        if ($cartItem['color_id'] != null) {
            $productColorSelect = $this->interfaceProductColorRepository->findById($cartItem['color_id']);
            if ($data['number'] > $cartItem['number']) {
                $value = $data['number'] - $cartItem['number'];
                $this->interfaceProductColorRepository->updateItem($cartItem['color_id'], [
                    'frozen_number' => $productColorSelect['frozen_number'] + $value,
                    'marketable_number' => $productColorSelect['marketable_number'] - $value,
                ]);
                if ($this->interfaceCartItemRepository->updateItem($id, ['number' => $cartItem['number'] + $value]))
                    return response()->json(['message' => 'successfully your transaction!'], HTTPResponse::HTTP_OK);
                return response()->json(['message' => 'sorry, your transaction fails!'], HTTPRespornse::HTTP_BAD_REQUEST);
            } else {
                $value = $cartItem['number'] - $data['number'];
                $this->interfaceProductColorRepository->updateItem($cartItem['color_id'], [
                    'frozen_number' => $productColorSelect['frozen_number'] - $value,
                    'marketable_number' => $productColorSelect['marketable_number'] + $value,
                ]);
                if ($this->interfaceCartItemRepository->updateItem($id, ['number' => $cartItem['number'] - $value]))
                    return response()->json(['message' => 'successfully your transaction!'], HTTPResponse::HTTP_OK);
                return response()->json(['message' => 'sorry, your transaction fails!'], HTTPRespornse::HTTP_BAD_REQUEST);
            }
        } else {
            $product = $this->interfaceProductRepository->findById($cartItem['product_id']);
            if ($data['number'] > $cartItem['number']) {

                $value = $data['number'] - $cartItem['number'];
                $this->interfaceProductRepository->updateItem($cartItem['product_id'], [
                    'frozen_number' => $product['frozen_number'] + $value,
                    'marketable_number' => $product['marketable_number'] - $value,
                ]);
                if ($this->interfaceCartItemRepository->updateItem($id, ['number' => $cartItem['number'] + $value]))
                    return response()->json(['message' => 'successfully your transaction!'], HTTPResponse::HTTP_OK);
                return response()->json(['message' => 'sorry, your transaction fails!'], HTTPRespornse::HTTP_BAD_REQUEST);
            } else {

                $value = $cartItem['number'] - $data['number'];
                $this->interfaceProductRepository->updateItem($cartItem['product_id'], [
                    'frozen_number' => $product['frozen_number'] - $value,
                    'marketable_number' => $product['marketable_number'] + $value,
                ]);
                if ($this->interfaceCartItemRepository->updateItem($id, ['number' => $cartItem['number'] - $value]))
                    return response()->json(['message' => 'successfully your transaction!'], HTTPResponse::HTTP_OK);
                return response()->json(['message' => 'sorry, your transaction fails!'], HTTPRespornse::HTTP_BAD_REQUEST);
            }
        }


    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id):JsonResponse
    {

        $cartItem = $this->interfaceCartItemRepository->findById($id);
        if ($cartItem['color_id'] != null) {
            $productColorSelect = $this->interfaceProductColorRepository->findById($cartItem['color_id']);
            $this->interfaceProductColorRepository->updateItem($cartItem['color_id'], [
                'marketable_number' => $productColorSelect['marketable_number'] + $cartItem['number'],
                'frozen_number' => $productColorSelect['frozen_number'] - $cartItem['number'],
            ]);
            if ($this->interfaceCartItemRepository->deleteData($id))
                return response()->json(['message' => 'successfully your transaction!'], HTTPResponse::HTTP_OK);
            return response()->json(['message' => 'sorry, your transaction fails!'], HTTPRespornse::HTTP_BAD_REQUEST);
        } else {
            $product = $this->interfaceProductRepository->findById($cartItem['product_id']);
            $this->interfaceProductRepository->updateItem($cartItem['product_id'], [
                'marketable_number' => $product['marketable_number'] + $cartItem['number'],
                'frozen_number' => $product['frozen_number'] - $cartItem['number'],
            ]);
            if ($this->interfaceCartItemRepository->deleteData($id))
                return response()->json(['message' => 'successfully your transaction!'], HTTPResponse::HTTP_OK);
            return response()->json(['message' => 'sorry, your transaction fails!'], HTTPRespornse::HTTP_BAD_REQUEST);

        }

    }
}
