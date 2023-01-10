<?php

namespace App\Repository;


use App\Common\RepositoryInterface;
use App\Models\Promotion;
use Illuminate\Database\Eloquent\Model;

interface PromotionRepositoryInterface extends RepositoryInterface
{
    public function syncProducts($model, array $productIds);

    public function attachProduct($model, $productId);

    public function detachProduct($model, $productId);
}