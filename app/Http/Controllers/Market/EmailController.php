<?php

namespace App\Http\Controllers\Market;

use App\Http\Controllers\Controller;
use App\Http\Requests\email\EmailRequest;
use App\Http\Requests\email\StoreEmailRequest;
use App\Http\Requests\email\UpdateEmailRequest;
use App\Http\Requests\sms\StoreSmsRequest;
use App\Http\Resources\email\EmailResource;
use App\Http\Services\Message\Email\EmailService;
use App\Http\Services\Message\MessageService;
use App\Jobs\SendEmail;
use App\Models\Market\EmailFile;
use App\Models\User;
use App\Repositories\MySQL\EmailRepository\InterfaceEmailRepository;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
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

    public function __construct(InterfaceEmailRepository $interfaceEmailRepository)
    {

        $this->interfaceEmailRepository = $interfaceEmailRepository;
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
        $data['published_at'] = \Morilog\Jalali\Jalalian::fromFormat('Y-m-d HidH:i:s', $data['published_at'])->toCarbon();

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
    public function destroy(int $id):JsonResponse
    {
        if($this->interfaceEmailRepository->deleteData($id))
            return response()->json(['message' => 'successfully your transaction!'], HTTPResponse::HTTP_OK);
        return response()->json(['message' => 'sorry, your transaction fails!'], HTTPResponse::HTTP_BAD_REQUEST);
    }


    public function sendEmail(int $id):JsonResponse
    {
        $data=$this->interfaceEmailRepository->findById($id);
            $subject=$data['subject'];
            $body=$data['body'];
            $users=User::where('email','!=',null)->get();
            $attachment=EmailFile::where('public_mail_id','=',$data['id'])->first();
          if(event(new \App\Events\SendEmail($subject,$body,$attachment['file_path']))){
              $this->interfaceEmailRepository->updateItem($id,[
                  'published_at'=>Carbon::now(),
              ]);
              return response()->json(['message' => 'successfully your transaction!'], HTTPResponse::HTTP_OK);

          }
        return response()->json(['message' => 'sorry, your transaction fails!'], HTTPResponse::HTTP_BAD_REQUEST);
    }

}
