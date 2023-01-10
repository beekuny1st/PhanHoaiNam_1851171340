<?php

namespace App\Repository;


use App\Common\RepositoryInterface;
use App\Models\ProductTag;
use Illuminate\Database\Eloquent\Model;

interface ProductTagRepositoryInterface extends RepositoryInterface
{
    public function syncProducts($tag, array $productIds);

    public function attachProduct($tag, $productId);

    public function detachProduct($tag, $productId);
}