<?php

namespace App\Http\Controllers\Market;

use App\Events\SendEmailForAllUsersEvent;
use App\Http\Controllers\Controller;
use App\Http\Requests\email\EmailRequest;
use App\Http\Requests\email\SendOrderPaymentRequest;
use App\Http\Requests\email\StoreEmailRequest;
use App\Http\Requests\email\UpdateEmailRequest;
use App\Http\Requests\sms\StoreSmsRequest;
use App\Http\Resources\email\EmailResource;
use App\Jobs\SendEmailForAllUsersJob;
use App\Jobs\SendOrderPaymentEmailJob;
use App\Mail\SendEmail;
use App\Models\Market\EmailFile;
use App\Models\Market\Order;
use App\Models\User;
use App\Repositories\MySQL\EmailRepository\InterfaceEmailRepository;
use App\Repositories\MySQL\OrderItemRepository\InterfaceOrderItemRepository;
use App\Repositories\MySQL\OrderRepository\InterfaceOrderRepository;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Symfony\Component\HttpFoundation\Response as HTTPResponse;

/**
 * @group Email
 *
 *API endpoints for Email Services
 *
 *
 */
class EmailController extends Controller
{

    private InterfaceEmailRepository $interfaceEmailRepository;
    private InterfaceOrderRepository $interfaceOrderRepository;
    private InterfaceOrderItemRepository $interfaceOrderItemRepository;

    public function __construct(InterfaceEmailRepository $interfaceEmailRepository,
                                InterfaceOrderRepository $interfaceOrderRepository,
                                InterfaceOrderItemRepository $interfaceOrderItemRepository
    )
    {

        $this->interfaceEmailRepository = $interfaceEmailRepository;
        $this->interfaceOrderRepository = $interfaceOrderRepository;
        $this->interfaceOrderItemRepository = $interfaceOrderItemRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(EmailRequest $request): AnonymousResourceCollection
    {
        $count = @$request->count ?? 10;
        $subject = @$request->subject;
        $stats = @$request->status;
        $published_at = @$request->published_at;

        $emails = $this->interfaceEmailRepository->query();

        if ($stats != null)
            $emails = $emails->whereStaus($stats);
        if ($subject)
            $emails = $emails->whereSubject($subject);
        if ($published_at)
            $emails = $emails->wherePublishedAt($published_at);


        return EmailResource::collection($emails->paginate($count));


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
    public function store(StoreEmailRequest $request): JsonResponse
    {
        $data = @$request->except(['_token']);
        $data['published_at'] = \Morilog\Jalali\Jalalian::fromFormat('Y-m-d H:i:s', $data['published_at'])->toCarbon();

        if ($this->interfaceEmailRepository->insertData($data))
            return response()->json(['message' => 'successfully your transaction!'], HTTPResponse::HTTP_OK);
        return response()->json(['message' => 'sorry, your transaction fails!'], HTTPResponse::HTTP_BAD_REQUEST);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id): EmailResource
    {
        return EmailResource::make($this->interfaceEmailRepository->findById($id));
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
    public function update(UpdateEmailRequest $request, int $id): JsonResponse
    {
        $data = @$request->except(['_token']);
        if ($data['published_at'])
            $data['published_at'] = \Morilog\Jalali\Jalalian::fromFormat('Y-m-d H:i:s', $data['published_at'])->toCarbon();
        if ($this->interfaceEmailRepository->updateItem($id, $data))
            return response()->json(['message' => 'successfully your transaction!'], HTTPResponse::HTTP_OK);
        return response()->json(['message' => 'sorry, your transaction fails!'], HTTPResponse::HTTP_BAD_REQUEST);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id): JsonResponse
    {
        if ($this->interfaceEmailRepository->deleteData($id))
            return response()->json(['message' => 'successfully your transaction!'], HTTPResponse::HTTP_OK);
        return response()->json(['message' => 'sorry, your transaction fails!'], HTTPResponse::HTTP_BAD_REQUEST);
    }


    public function sendEmailForAllUsers(int $id): JsonResponse
    {

        $data = $this->interfaceEmailRepository->findById($id);

        $attachment = EmailFile::where('public_mail_id', '=', $data['id'])->first();

//        SendEmailForAllUsersJob::dispatch($data['subject'],$data['body'],$attachment['file_path']);
        if (event(new SendEmailForAllUsersEvent($data['subject'], $data['body'], @$attachment['file_path']))) {
            $this->interfaceEmailRepository->updateItem($id,
                [
                    'published_at' => now()
                ]);
            return response()->json(['message' => 'successfully your transaction!'], HTTPResponse::HTTP_OK);
        }
        return response()->json(['message' => 'sorry, your transaction fails!'], HTTPResponse::HTTP_BAD_REQUEST);
    }


    public function sendOrderPaymentEmail(SendOrderPaymentRequest $request)
    {

        $data=$request->except(['_token']);
        $order=$this->interfaceOrderRepository->findById($data['order_id']);
        $user=User::find($order['user_id'])->first();
        if($order['payment_status']==1){
           $orderItems= $this->interfaceOrderItemRepository->findOrderItemsWithOrderID($order['id']);
            SendOrderPaymentEmailJob::dispatch($user,$order,$orderItems);
            return response()->json(['message' => 'successfully your transaction!'], HTTPResponse::HTTP_OK);
        }
        return response()->json(['message' => 'sorry, your transaction fails because order not payment!'], HTTPResponse::HTTP_BAD_REQUEST);


    }

}
