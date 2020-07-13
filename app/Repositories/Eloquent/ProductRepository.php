<?php

namespace App\Repositories\Eloquent;

use App\Repositories\ProductRepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use App\Models\Product;

class ProductRepository extends BaseRepository implements ProductRepositoryInterface {

    public function __construct(Product $model)
    {
        parent::__construct($model);
    }

    public function getAll()
    {
        $data['status'] = 1;
        $data['data'] = $this->model->all();
        return $data;
    }
}

