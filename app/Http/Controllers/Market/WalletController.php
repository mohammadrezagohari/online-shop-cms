<?php

namespace App\Http\Controllers\Market;

use App\Http\Controllers\Controller;
use App\Http\Requests\wallet\StoreWalletRequest;
use App\Http\Requests\wallet\UpdateWalletRequest;
use App\Http\Requests\wallet\WalletChangeRequest;
use App\Http\Requests\wallet\WalletRequest;
use App\Http\Resources\wallet\WalletResource;
use App\Repositories\MySQL\WalletRepository\InterfaceWalletRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Symfony\Component\HttpFoundation\Response as HTTPResponse;


class WalletController extends Controller
{
    private InterfaceWalletRepository $interfaceWalletRepositorty;

    public function __construct(InterfaceWalletRepository $interfaceWalletRepositorty)
    {
        $this->interfaceWalletRepositorty = $interfaceWalletRepositorty;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(WalletRequest $request): AnonymousResourceCollection
    {
        $count = @$request->count ?? 10;
        $amount = @$request->amount;
        $has_credit = @$request->has_credit;
        $status = @$request->status;
        $user_id = @$request->user_id;
        $wallets = $this->interfaceWalletRepositorty->query();


        if ($amount)
            $wallets = $wallets->whereAmount($amount);

        if ($has_credit != null)
            $wallets = $wallets->whereHasCredit($has_credit);

        if ($status != null)
            $wallets = $wallets->whereStatus($status);

        if ($user_id)
            $wallets = $wallets->whereUserId($user_id);


        return WalletResource::collection($wallets->paginate($count));
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
    public function store(StoreWalletRequest $request): JsonResponse
    {
        $data = $request->except(['_token']);
        if ($this->interfaceWalletRepositorty->insertData($data))
            return response()->json(['message' => 'successfully your transaction!'], HTTPResponse::HTTP_OK);
        return response()->json(['message' => 'sorry, your transaction fails!'], HTTPResponse::HTTP_BAD_REQUEST);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id): WalletResource
    {
        return WalletResource::make($this->interfaceWalletRepositorty->findById($id));
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
    public function update(UpdateWalletRequest $request, int $id): JsonResponse
    {
        $data = $request->except(["_token"]);
        if ($this->interfaceWalletRepositorty->updateItem($id, $data))
            return response()->json(['message' => 'successfully your transaction!'], HTTPResponse::HTTP_OK);
        return response()->json(['message' => 'sorry, your transaction fails!'], HTTPResponse::HTTP_BAD_REQUEST);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id): JsonResponse
    {
        if ($this->interfaceWalletRepositorty->deleteData($id))
            return response()->json(['message' => 'successfully your transaction!'], HTTPResponse::HTTP_OK);
        return response()->json(['message' => 'sorry, your transaction fails!'], HTTPResponse::HTTP_BAD_REQUEST);
    }


    public function walletIncrese(int $id, WalletChangeRequest $request)
    {
        $amount = $this->interfaceWalletRepositorty->findById($id)['amount'];
        if ($this->interfaceWalletRepositorty->updateItem($id, [
            'amount' => $amount + $request->amount
        ])) {
            return response()->json(['message' => 'successfully your transaction!'], HTTPResponse::HTTP_OK);
        }
        return response()->json(['message' => 'sorry, your transaction fails!'], HTTPResponse::HTTP_BAD_REQUEST);
    }

    public function walletDecrese(int $id, WalletChangeRequest $request)
    {
        $amount = $this->interfaceWalletRepositorty->findById($id)['amount'];
        if ($amount >= $request->amount) {
            if ($this->interfaceWalletRepositorty->updateItem($id, [
                'amount' => $amount - $request->amount
            ])) {
                return response()->json(['message' => 'successfully your transaction!'], HTTPResponse::HTTP_OK);
            }
            return response()->json(['message' => 'sorry, your transaction fails!'], HTTPResponse::HTTP_BAD_REQUEST);
        }
        return response()->json(['message' => 'sorry, your transaction fails because your amount bigger than wallet inventory!'], HTTPResponse::HTTP_BAD_REQUEST);

    }
}
