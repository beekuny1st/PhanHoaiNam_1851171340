<?php

namespace App\Repository\Eloquent;


use App\Common\EloquentRepository;
use App\Models\ProductAttribute;
use App\Repository\ProductAttributeRepositoryInterface;

class ProductAttributeRepository extends EloquentRepository implements ProductAttributeRepositoryInterface
{
    public function getModel()
    {
        return ProductAttribute::class;
    }

}