<?php

namespace App\Repositories\Eloquent;

use App\Repositories\EloquentRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

class BaseRepository implements EloquentRepositoryInterface
{
    protected  $model;

    /*
     * inject the model
     */
    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function create($data)
    {
        $this->model->create($data);
    }
}
