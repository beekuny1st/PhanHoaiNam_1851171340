<?php

namespace App\Repository\Eloquent;


use App\Common\EloquentRepository;
use App\Common\Enum\EziWebRemoteCacheTypeEnum;
use App\Common\Exceptions\ObjectNotFoundException;
use App\Events\ClearCacheEvent;
use App\Models\MenuPosition;
use App\Repository\MenuPositionRepositoryInterface;

class MenuPositionRepository extends EloquentRepository implements MenuPositionRepositoryInterface
{
    public function getModel()
    {
        return MenuPosition::class;
    }

    public function create(array $attributes, $with = [], $withCount = [])
    {
        $result = parent::create($attributes, $with, $withCount);
        ClearCacheEvent::dispatch(EziWebRemoteCacheTypeEnum::MENUS);
        return $result;
    }

    public function update($id, array $attributes, $with = [], $withCount = [])
    {
        $result = parent::update($id, $attributes, $with, $withCount);
        ClearCacheEvent::dispatch(EziWebRemoteCacheTypeEnum::MENUS);
        return $result;
    }

    public function delete($id, $with = [])
    {
        $model = $id;
        if (is_numeric($id)) {
            $model = $this->findById($id);
        }
        if ($model && $model instanceof MenuPosition) {
            $model->menus()->delete();
            $model->delete();
            ClearCacheEvent::dispatch(EziWebRemoteCacheTypeEnum::MENUS);
            return true;
        } else {
            throw new ObjectNotFoundException();
        }
    }
}