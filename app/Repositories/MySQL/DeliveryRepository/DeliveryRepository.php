<?php

namespace App\Repositories\MySQL\DeliveryRepository;

use App\Models\Market\Delivery;
use App\Repositories\MySQL\BaseRepository;

class DeliveryRepository extends BaseRepository implements InterfaceDeliveryRepository{

    protected Delivery $model;

    public function __construct(Delivery $model)
    {
        parent::__construct($model);
        $this->model=$model;
    }
}