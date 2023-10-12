<?php

namespace App\Repositories\MySQL\RateAverageRepository;

use App\Models\Market\RateAverage;
use App\Repositories\MySQL\BaseRepository;
use App\Repositories\MySQL\RateAverageRepository\InterfaceRateAverageRepository;

class RateAverageRepository extends BaseRepository implements InterfaceRateAverageRepository
{

    protected RateAverage $model;

    public function __construct(RateAverage $model)
    {
        parent::__construct($model);
        $this->model = $model;
    }
    public function getRateAverageRowWithProductIdAndProductCategoryQuestionId(int $productId, int $productCategoryQuestionId)
    {
        return $this->model->where("product_id","=",$productId)->where("product_category_question_id","=",$productCategoryQuestionId)->first();
    }
}
