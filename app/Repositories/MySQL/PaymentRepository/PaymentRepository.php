<?php

namespace App\Repositories\MySQL\PaymentRepository;

use App\Models\Market\Payment;
use App\Repositories\MySQL\BaseRepository;

class PaymentRepository extends BaseRepository implements InterfacePaymentRepository{

    protected Payment $model;

    public function __construct(Payment $model)
    {
        parent::__construct($model);
        $this->model=$model;
    }
}