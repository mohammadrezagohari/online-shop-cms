<?php

namespace App\Repositories\MySQL\SmsRepository;


use App\Models\Market\Sms;
use App\Repositories\MySQL\BaseRepository;

class SmsRepository extends BaseRepository implements InterfaceSmsRepository{

    protected Sms $model;


    public function __construct(Sms $model)
    {
        parent::__construct( $model);
        $this->model=$model;
    }

}
