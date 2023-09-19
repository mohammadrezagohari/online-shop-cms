<?php

namespace App\Repositories\MySQL\ContactRepository;

use App\Models\Contact;
use App\Repositories\MySQL\BaseRepository;

class ContactRepository extends BaseRepository implements InterfaceContactRepository{

    protected Contact $model;

    public function __construct(Contact $model)
    {
        parent::__construct($model);
        $this->model=$model;
    }
}