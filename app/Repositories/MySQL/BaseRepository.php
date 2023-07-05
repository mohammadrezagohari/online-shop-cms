<?php

namespace App\Repositories\MySQL;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use JetBrains\PhpStorm\ArrayShape;
use PHPUnit\Exception;

/******************************************************
 * @class BaseRepository
 *  In this class we create our popular methods
 *  such as get all data , find by id and CRUD actions
 *******************************************************/
class BaseRepository implements IBaseRepository
{
    /***************************************
     * @var Model $currentModel
     *  define model type with this property
     ****************************************/
    private Model $model;

    /********************************************************
     * @param Model $model
     * We use the constructor for repository constructor type
     * So with constructor we can assign your select model
     *********************************************************/
    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    /***************
     * @return Model
     */
    public function query(): Model
    {
        return $this->model;
    }

    /************************
     * @method  array|Collection|\Illuminate\Support\Collection getAll()
     *  get all of your model
     ************************/
    public function getAll(): array|Collection|\Illuminate\Support\Collection
    {
        return $this->model->get();
    }

    /*************************
     * @method Model|array|Collection|null findById()
     * @param $id
     * find your select method
     *************************/
    public function findById($id): Model|array|Collection|null
    {
        return $this->model->findOrFail($id);
    }


    /******************************
     * @method Model insertData()
     * @param $data
     * new instance of your model
     ******************************/
    public function insertData($data): Model
    {
        return $this->model->create($data);
    }

    /*******************************
     * update your instance of model
     * @method bool updateData()
     * @param $identity
     * @param $data
     * @return bool
     *******************************/
    public function updateData($identity, $data): bool
    {
        $model = $this->model->find($identity);
        if (!@$model)
            return false;
        foreach ($model as $index => $field) {
            $model[$index] = $data[$index];
        }
        $model->save();
        return true;
    }


    public function updateItem($identity, $data): bool
    {
        $model = $this->model->find($identity);
        foreach ($data as $key => $value) {
            $model[$key] = $value;
        }
        return $model->save();

    }

    /*******************************
     * drop instance of model
     * @method bool deleteData()
     * @param int $identity
     *******************************/
    public function deleteData($identity): ?bool
    {
        $model = $this->model->find($identity);
        if (!@$model)
            return false;
        return $model->delete();
    }

    /*******************************************
     * Dynamic Search by table column and value
     * @param $column
     * @param $value
     * @return Model|Builder
     ********************************************/
    public function searchByColumn($column, $value): Model|Builder
    {
        return $this->model->where($column, 'like', '%' . $value . '%');//->get()
    }

}
