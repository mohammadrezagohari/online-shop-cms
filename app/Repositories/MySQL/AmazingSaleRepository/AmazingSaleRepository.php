<?php

namespace App\Repositories\MySQL\AmazingSaleRepository;

use App\Models\Market\AmazingSale;
use App\Repositories\MySQL\BaseRepository;
use Carbon\Carbon;

class AmazingSaleRepository extends BaseRepository implements InterfaceAmazingSaleRepository{

    protected AmazingSale $model;

    public function __construct(AmazingSale $model)
    {
        parent::__construct($model);
        $this->model=$model;
    }

    public function amazingSaleWithProductIdAndActive($productId)
    {

      return  $this->model->where('product_id','=',$productId)->where('start_date','<',Carbon::now())->where('end_date','>',Carbon::now())->where('status','=',1)->first();
    }
}
