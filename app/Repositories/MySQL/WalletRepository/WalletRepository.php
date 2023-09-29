<?php

namespace App\Repositories\MySQL\WalletRepository;

use App\Models\Market\Wallet;
use App\Repositories\MySQL\BaseRepository;

class WalletRepository extends BaseRepository implements InterfaceWalletRepository{

    protected Wallet $model;

    public function __construct(Wallet $model)
    {
        parent::__construct($model);
        $this->model=$model;
    }
}