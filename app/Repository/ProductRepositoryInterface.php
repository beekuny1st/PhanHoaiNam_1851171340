<?php

namespace App\Repository;


use App\Common\RepositoryInterface;
use App\Models\Product;
use Illuminate\Database\Eloquent\Model;

interface ProductRepositoryInterface extends RepositoryInterface
{
    public function syncTags($product, array $tagIds);

    public function attachTag($product, $tagId);

    public function detachTag($product, $tagId);
}