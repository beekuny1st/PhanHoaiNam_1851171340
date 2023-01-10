<?php

namespace App\Repository\Eloquent;


use App\Common\EloquentRepository;
use App\Models\Ward;
use App\Repository\WardRepositoryInterface;

class WardRepository extends EloquentRepository implements WardRepositoryInterface
{
    public function getModel()
    {
        return Ward::class;
    }

}