<?php

namespace App\Repository\Eloquent;


use App\Common\EloquentRepository;
use App\Models\OrderItem;
use App\Repository\OrderItemRepositoryInterface;

class OrderItemRepository extends EloquentRepository implements OrderItemRepositoryInterface
{
    public function getModel()
    {
        return OrderItem::class;
    }

}