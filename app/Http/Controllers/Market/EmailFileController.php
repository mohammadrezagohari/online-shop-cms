<?php

namespace App\Http\Controllers\Market;

use App\Http\Controllers\Controller;
use App\Http\Requests\emailFile\EmailFileRequest;
use App\Http\Requests\emailFile\StoreEmailFileRequest;
use App\Http\Requests\emailFile\UpdateEmailFileRequest;
use App\Http\Resources\emailFile\EmailFileResource;
use App\Repositories\MySQL\EmailFileRepository\InterfaceEmailFileRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Symfony\Component\HttpFoundation\Response as HTTPResponse;
use function App\upload_asset_file;

/**
 * @group EmailFile
 *
 *API endpoints for EmailFile Services
 *
 *
 */
class EmailFileController extends Controller
{

    private InterfaceEmailFileRepository $interfaceEmailFileRepository;

    public function __construct(InterfaceEmailFileRepository $interfaceEmailFileRepository)
    {

        $this->interfaceEmailFileRepository = $interfaceEmailFileRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(EmailFileRequest $request): AnonymousResourceCollection
    {
        $count = @$request->count ?? 10;
        $status = @$request->status;
        $publi_mail_id = @$request->public_file_id;

        $emailFiles = $this->interfaceEmailFileRepository->query();

        if (@$status != null)
            $emailFiles = $emailFiles->whereStatus($status);
        if (@$publi_mail_id)
            $emailFiles = $emailFiles->wherePublicMailId($publi_mail_id);

        return EmailFileResource::collection($emailFiles->paginate($count));


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
    public function store(StoreEmailFileRequest $request):JsonResponse
    {
        $data = @$request->except(['_token']);
        $data['file_size'] = $request->file('file')->getSize();
        $data['file_type'] = $request->file('file')->getMimeType();
        $data['file_path'] = upload_asset_file($request->file('file'), 'email-file');
        if ($this->interfaceEmailFileRepository->insertData($data))
            return response()->json(['message' => 'successfully your transaction!'], HTTPResponse::HTTP_OK);
        return response()->json(['message' => 'sorry, your transaction fails!'], HTTPResponse::HTTP_BAD_REQUEST);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id): EmailFileResource
    {
        return EmailFileResource::make($this->interfaceEmailFileRepository->findById($id));
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
    public function update(UpdateEmailFileRequest $request, int $id):JsonResponse
    {
        $data = @$request->except(['_token','file']);
        if ($request->file('file')) {
            $data['file_size'] = $request->file('file')->getSize();
            $data['file_type'] = $request->file('file')->getMimeType();
            $data['file_path'] = upload_asset_file($request->file('file'), 'email-file');
            $file_path = $this->interfaceEmailFileRepository->findById($id)['file_path'];
            \File::delete($file_path);
        }
        if ($this->interfaceEmailFileRepository->updateItem($id, $data))
            return response()->json(['message' => 'successfully your transaction!'], HTTPResponse::HTTP_OK);
        return response()->json(['message' => 'sorry, your transaction fails!'], HTTPResponse::HTTP_BAD_REQUEST);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id):JsonResponse
    {
        $file_path = $this->interfaceEmailFileRepository->findById($id)['file_path'];
        \File::delete($file_path);
        if($this->interfaceEmailFileRepository->deleteData($id))
            return response()->json(['message' => 'successfully your transaction!'], HTTPResponse::HTTP_OK);
        return response()->json(['message' => 'sorry, your transaction fails!'], HTTPResponse::HTTP_BAD_REQUEST);
    }
}
