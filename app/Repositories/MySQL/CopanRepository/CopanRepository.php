<?php

namespace App\Repositories\MySQL\CopanRepository;

use App\Models\Market\Copan;
use App\Repositories\MySQL\BaseRepository;
use Carbon\Carbon;
use Symfony\Component\HttpFoundation\Response as HTTPResponse;

class CopanRepository extends BaseRepository implements InterfaceCopanRepository
{

    protected Copan $model;

    public function __construct(Copan $model)
    {
        parent::__construct($model);
        $this->model = $model;
    }


    public function addNumberOfUseCode(int $id): void
    {
       $copan= $this->model->find($id)->first();
       $copan["number_of_use_code"]= $copan["number_of_use_code	"]+1;
       $copan->save();
    }

    public function whereCode(string $code)
    {
       return $this->model->where('code', '=', $code)->first();
    }
}
