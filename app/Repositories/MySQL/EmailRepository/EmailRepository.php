<?php


namespace App\Repositories\MySQL\EmailRepository;



use App\Models\Market\Email;
use App\Repositories\MySQL\BaseRepository;
use Illuminate\Database\Eloquent\Model;

class EmailRepository extends BaseRepository implements InterfaceEmailRepository{

    protected Email $model;

    public function __construct(Email $model)
    {
        parent::__construct($model);
    }

}
