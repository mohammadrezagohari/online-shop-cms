<?php

namespace App\Repositories\MySQL\AboutAttachmentRepository;

use App\Models\AboutAttachment;
use App\Repositories\MySQL\BaseRepository;

class AboutAttachmentRepository extends BaseRepository implements InterfaceAboutAttachmentRepository{

    protected AboutAttachment $model;

    public function __construct(AboutAttachment $model)
    {
        parent::__construct($model);
        $this->model=$model;
    }
}