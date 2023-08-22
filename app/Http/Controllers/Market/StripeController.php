<?php

namespace App\Http\Controllers\Market;

use App\Http\Controllers\Controller;
use App\Http\Requests\stripe\StripeRequest;
use App\Http\Requests\stripe\StripeStoreRequest;
use App\Http\Resources\stripe\StripeResource;
use App\Models\Market\Order;
use App\Models\Market\StripeTransaction;
use App\Repositories\MySQL\StripeTransactionRepository\InterfaceStripeTransactionRepository;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpFoundation\Response as HTTPResponse;



class StripeController extends Controller
{
    private InterfaceStripeTransactionRepository $interfaceStripeTransactionRepository;

    public function __construct(InterfaceStripeTransactionRepository $interfaceStripeTransactionRepository)
    {
       $this->interfaceStripeTransactionRepository=$interfaceStripeTransactionRepository;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(StripeRequest $request):AnonymousResourceCollection
    {
        $count = @$request->count ?? 10;
     
        $user_id = @$request->user_id;
        $order_id = @$request->order_id;
        $status = @$request->status;
        $transactions = $this->interfaceStripeTransactionRepository->query();

      
        if (@$status != null)
            $transactions = $transactions->whereStatus($status);
        if (@$user_id)
            $transactions = $transactions->whereUserId($user_id);
        if (@$order_id)
            $transactions = $transactions->whereOrderId($order_id);


        return StripeResource::collection($transactions->paginate($count));
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
        //
    }


    public function checkout(StripeStoreRequest $request)
    {
        $stripe = new \Stripe\StripeClient(env('STRIPE_SEKRET_KEY'));
        $order=Order::find($request->order_id);
        
        $lineItems = [[
            'price_data' => [
                'currency' => 'usd',
                'product_data' => [
                    'name' => "buy products",
                ],
                'unit_amount' => $order->order_final_amount_with_copan_discount * 100,
            ],
            'quantity' => 1,
        ]];

        $checkout_session = $stripe->checkout->sessions->create([
            'line_items' => $lineItems,
            'mode' => 'payment',
            'success_url' => route('checkout.success', [], true) . "?session_id={CHECKOUT_SESSION_ID}",
            'cancel_url' => route('checkout.cancel', [], true),
        ]);
        
        $stripe=new StripeTransaction();
        $stripe->order_id=$request->order_id;
        $stripe->user_id=$request->user_id;
        $stripe->session_id= $checkout_session->id;
        $stripe->status="unpaid";
        $stripe->amount_subtotal=$checkout_session->amount_subtotal;
        $stripe->amount_total=$checkout_session->amount_total;
        $stripe->currency=$checkout_session->currency;
        $stripe->save();


        return $checkout_session->url;
        
    }


    public function success(Request $request)
    {
        $stripe = new \Stripe\StripeClient(env('STRIPE_SEKRET_KEY'));
        $sessionId = $request->get('session_id');
        $session = $stripe->checkout->sessions->retrieve($sessionId);

         try {
           $session = $stripe->checkout->sessions->retrieve($sessionId);
            if (!$session) {
                throw new NotFoundHttpException;
            }
            $stripe = StripeTransaction::where('session_id', '=', $session->id)->first();
            if(!$stripe){
                throw new NotFoundHttpException();
            }
            if ($stripe && $stripe->status == 'unpaid') {
                $stripe->status = "paid";
                $stripe->save();
            }
            return response()->json(['message' => 'successfully your transaction!'], HTTPResponse::HTTP_OK);
        } catch (\Exception $e) {
            throw new NotFoundHttpException($e->getMessage());
        }

    }



    public function cancel()
    {
        return response()->json(["message" => "not ok response in bank"], HTTPResponse::HTTP_BAD_REQUEST);
    }

    public function webhook()
    {
        $stripe = new \Stripe\StripeClient(env('STRIPE_SEKRET_KEY'));

        // This is your Stripe CLI webhook secret for testing your endpoint locally.
        $endpoint_secret = env('STRIPE_WEBHOOK_SECRET');
        $payload = @file_get_contents('php://input');
        $sig_header = $_SERVER['HTTP_STRIPE_SIGNATURE'];
        $event = null;

        try {
            $event = \Stripe\Webhook::constructEvent(
                $payload,
                $sig_header,
                $endpoint_secret
            );
        } catch (\UnexpectedValueException $e) {
            // Invalid payload
            return response()->json(["message" => $e->getMessage()], HTTPResponse::HTTP_BAD_REQUEST);
        } catch (\Stripe\Exception\SignatureVerificationException $e) {
            // Invalid signature
            return response()->json(["message" => $e->getMessage()], HTTPResponse::HTTP_BAD_REQUEST);
        }

        // Handle the event
        switch ($event->type) {
            case 'payment_intent.succeeded':
                // ... handle other event types

                $session = $event->data->object;
                $sessionId=$session->id;
                $stripe = StripeTransaction::where('session_id', '=', $session->id)->first();
                if ($stripe && $stripe->status == 'unpaid') {
                    $stripe->status = "paid";
                    $stripe->save();
                    //send email to customer
                }
              
            default:
                echo 'Received unknown event type ' . $event->type;
        }

        return response()->json(['message' => 'successfully your transaction!'], HTTPResponse::HTTP_OK);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
    public function destroy(string $id)
    {
        //
    }
}
