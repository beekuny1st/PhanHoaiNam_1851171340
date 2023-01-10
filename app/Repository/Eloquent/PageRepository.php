<?php

namespace App\Repository\Eloquent;


use App\Common\EloquentRepository;
use App\Common\Enum\EziWebRemoteCacheTypeEnum;
use App\Common\Exceptions\ObjectNotFoundException;
use App\Events\ClearCacheEvent;
use App\Models\Page;
use App\Repository\PageRepositoryInterface;

class PageRepository extends EloquentRepository implements PageRepositoryInterface
{
    public function getModel()
    {
        return Page::class;
    }

    public function create(array $attributes, $with = [], $withCount = [])
    {
        $result = parent::create($attributes, $with, $withCount);
        ClearCacheEvent::dispatch(EziWebRemoteCacheTypeEnum::PAGES);
        return $result;
    }

    public function update($id, array $attributes, $with = [], $withCount = [])
    {
        $result = parent::update($id, $attributes, $with, $withCount);
        ClearCacheEvent::dispatch(EziWebRemoteCacheTypeEnum::PAGES);
        return $result;
    }

    public function delete($id, $with = [])
    {
        $model = $id;
        if (is_numeric($id)) {
            $model = $this->findById($id);
        }
        if ($model && $model instanceof Page) {
            $model->article()->delete();
            $model->meta()->delete();
            $model->blocks()->delete();
            $model->structured_datas()->delete();
            if ($model->delete()) {
                ClearCacheEvent::dispatch(EziWebRemoteCacheTypeEnum::PAGES);
                return true;
            } else {
                throw new \Exception('Không thể xóa');
            }
        } else {
            throw new ObjectNotFoundException();
        }
    }

}