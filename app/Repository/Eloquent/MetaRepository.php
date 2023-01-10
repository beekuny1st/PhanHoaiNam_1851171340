<?php

namespace App\Repository\Eloquent;


use App\Common\EloquentRepository;
use App\Models\MetaData;
use App\Repository\MetaDataRepositoryInterface;

class MetaDataRepository extends EloquentRepository implements MetaDataRepositoryInterface
{
    public function getModel()
    {
        return MetaData::class;
    }

}