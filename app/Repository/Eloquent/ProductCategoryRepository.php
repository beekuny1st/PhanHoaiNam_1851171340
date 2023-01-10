<?php

namespace App\Repository\Eloquent;


use App\Common\EloquentRepository;
use App\Models\ProductCategory;
use App\Repository\ProductCategoryRepositoryInterface;

class ProductCategoryRepository extends EloquentRepository implements ProductCategoryRepositoryInterface
{
    public function getModel()
    {
        return ProductCategory::class;
    }

}