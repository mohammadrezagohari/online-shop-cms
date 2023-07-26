<?php



namespace App\Repositories\MySQL\EmailFileRepository;



use App\Models\Market\EmailFile;
use App\Repositories\MySQL\BaseRepository;

class EmailFileRepository extends BaseRepository implements InterfaceEmailFileRepository{

    protected EmailFile $model;

    public function __construct(EmailFile $model)
    {
        parent::__construct($model);
        $this->model=$model;
    }
}
