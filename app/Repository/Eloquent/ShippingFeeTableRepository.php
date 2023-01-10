<?php

namespace App\Repository\Eloquent;

use App\Common\EloquentRepository;
use App\Models\ShippingFeeTable;
use App\Repository\ShippingFeeTableRepositoryInterface;

class ShippingFeeTableRepository extends EloquentRepository implements ShippingFeeTableRepositoryInterface
{
    public function getModel()
    {
        return ShippingFeeTable::class;
    }

}