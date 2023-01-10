<?php

namespace App\Repository\Eloquent;


use App\Common\EloquentRepository;
use App\Common\Enum\EziWebRemoteCacheTypeEnum;
use App\Events\ClearCacheEvent;
use App\Models\DynamicTable;
use App\Repository\DynamicTableRepositoryInterface;

class DynamicTableRepository extends EloquentRepository implements DynamicTableRepositoryInterface
{
    public function getModel()
    {
        return DynamicTable::class;
    }

    public function create(array $attributes, $with = [], $withCount = [])
    {
        $result = parent::create($attributes, $with, $withCount);
        ClearCacheEvent::dispatch(EziWebRemoteCacheTypeEnum::DYNAMIC_TABLES);
        return $result;
    }

    public function update($id, array $attributes, $with = [], $withCount = [])
    {
        $result = parent::update($id, $attributes, $with, $withCount);
        ClearCacheEvent::dispatch(EziWebRemoteCacheTypeEnum::DYNAMIC_TABLES);
        return $result;
    }

    public function delete($id, $with = [])
    {
        $result = parent::delete($id, $with = []);
        ClearCacheEvent::dispatch(EziWebRemoteCacheTypeEnum::DYNAMIC_TABLES);
        return $result;
    }
}