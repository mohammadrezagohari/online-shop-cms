<?php

namespace App\Repositories\MySQL\StripeTransactionRepository;

use App\Models\Market\StripeTransaction;
use App\Repositories\MySQL\BaseRepository;

class StripeTransactionRepository extends BaseRepository implements InterfaceStripeTransactionRepository{

    protected StripeTransaction $model;

    public function __construct(StripeTransaction $model)
    {
        parent::__construct($model);
        $this->model=$model;
    }
}