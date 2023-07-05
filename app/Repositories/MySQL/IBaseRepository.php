<?php

namespace App\Repositories\MySQL;

interface IBaseRepository
{
    public function getAll();

    public function query();

    public function findById($id);

    public function insertData($data);

    public function updateData($identity, $data);

    public function updateItem($identity, $data);

    public function deleteData($identity);
}
