<?php

namespace App\Repositories\MySQL\TransactionRepository;

use App\Models\Market\Transaction;
use App\Repositories\MySQL\BaseRepository;

class TransactionRepository extends BaseRepository implements InterfaceTransactionRepository{

    protected Transaction $model;

    public function __construct(Transaction $model)
    {
        parent::__construct($model);
        $this->model=$model;
    }
}