<?php

namespace App\Repository\Eloquent;


use App\Common\EloquentRepository;
use App\Models\ProductTag;
use App\Repository\ProductTagRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

class ProductTagRepository extends EloquentRepository implements ProductTagRepositoryInterface
{
    public function getModel()
    {
        return ProductTag::class;
    }

    public function syncProducts($tag, array $productIds)
    {
        if ($tag instanceof ProductTag) {
            return $tag->products()->sync($productIds);
        }
        return false;

    }

    public function attachProduct($tag, $productId)
    {
        if ($tag instanceof ProductTag) {
            return $tag->products()->attach($productId);
        }
        return false;
    }

    public function detachProduct($tag, $productId)
    {
        if ($tag instanceof ProductTag) {
            return $tag->products()->detach($productId);
        }
        return false;
    }
}