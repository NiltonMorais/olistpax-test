<?php

namespace App\Repositories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;

class ProductRepository
{
    /**
     * @var Product
     */
    private $model;

    public function __construct(Product $model)
    {
        $this->model = $model;
    }

    public function all() : Collection
    {
        return $this->model->all();
    }
}