<?php

namespace App\Repository\Eloquent;


use App\Common\EloquentRepository;
use App\Models\Promotion;
use App\Repository\PromotionRepositoryInterface;

class PromotionRepository extends EloquentRepository implements PromotionRepositoryInterface
{
    public function getModel()
    {
        return Promotion::class;
    }

    public function syncProducts($model, array $productIds)
    {
        if ($model instanceof Promotion) {
            return $model->products()->sync($productIds);
        }
        return false;
    }

    public function attachProduct($model, $productId)
    {
        if ($model instanceof Promotion) {
            return $model->products()->attach($productId);
        }
        return false;
    }

    public function detachProduct($model, $productId)
    {
        if ($model instanceof Promotion) {
            return $model->products()->detach($productId);
        }
        return false;
    }

}