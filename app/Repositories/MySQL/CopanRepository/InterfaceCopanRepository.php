<?php

namespace App\Repositories\MySQL\CopanRepository;

use App\Repositories\MySQL\IBaseRepository;

interface InterfaceCopanRepository extends IBaseRepository{

    public function addNumberOfUseCode(int $id):void;
}

