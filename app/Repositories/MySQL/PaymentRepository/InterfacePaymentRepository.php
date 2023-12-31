<?php

namespace App\Repositories\MySQL\PaymentRepository;

use App\Repositories\MySQL\IBaseRepository;

interface InterfacePaymentRepository extends IBaseRepository{

    public function getPaymentableWithPaymentId(int $paymentId);

}

