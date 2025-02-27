<?php

namespace App\Http\Repositories;

use App\Http\Interfaces\ProductRepositoryInterface;
use App\Models\Product;

class ProductRepository extends BaseRepository implements ProductRepositoryInterface
{
    public function __construct(Product $model)
    {
        parent::__construct($model);
    }
}
