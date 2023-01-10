<?php

namespace App\Repository\Eloquent;


use App\Common\EloquentRepository;
use App\Common\Enum\EziWebRemoteCacheTypeEnum;
use App\Events\ClearCacheEvent;
use App\Models\DynamicTableRow;
use App\Repository\DynamicTableRowRepositoryInterface;

class DynamicTableRowRepository extends EloquentRepository implements DynamicTableRowRepositoryInterface
{
    public function getModel()
    {
        return DynamicTableRow::class;
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