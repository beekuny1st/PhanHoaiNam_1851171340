<?php

namespace App\Repository\Eloquent;


use App\Common\EloquentRepository;
use App\Common\Enum\EziWebRemoteCacheTypeEnum;
use App\Events\ClearCacheEvent;
use App\Models\Banner;
use App\Repository\BannerRepositoryInterface;

class BannerRepository extends EloquentRepository implements BannerRepositoryInterface
{
    public function getModel()
    {
        return Banner::class;
    }

    public function create(array $attributes, $with = [], $withCount = [])
    {
        $result = parent::create($attributes, $with, $withCount);
        ClearCacheEvent::dispatch(EziWebRemoteCacheTypeEnum::BANNERS);
        return $result;
    }

    public function update($id, array $attributes, $with = [], $withCount = [])
    {
        $result = parent::update($id, $attributes, $with, $withCount);
        ClearCacheEvent::dispatch(EziWebRemoteCacheTypeEnum::BANNERS);
        return $result;
    }

    public function delete($id, $with = [])
    {
        $result = parent::delete($id, $with = []);
        ClearCacheEvent::dispatch(EziWebRemoteCacheTypeEnum::BANNERS);
        return $result;
    }

}