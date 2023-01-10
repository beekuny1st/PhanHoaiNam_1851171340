<?php

namespace App\Repository\Eloquent;


use App\Common\EloquentRepository;
use App\Common\Enum\EziWebRemoteCacheTypeEnum;
use App\Events\ClearCacheEvent;
use App\Models\CompanyInformation;
use App\Repository\CompanyInformationRepositoryInterface;

class CompanyInformationRepository extends EloquentRepository implements CompanyInformationRepositoryInterface
{
    public function getModel()
    {
        return CompanyInformation::class;
    }

    public function create(array $attributes, $with = [], $withCount = [])
    {
        $result = parent::create($attributes, $with, $withCount);
        ClearCacheEvent::dispatch(EziWebRemoteCacheTypeEnum::COMPANY_INFORMATION);
        return $result;
    }

    public function update($id, array $attributes, $with = [], $withCount = [])
    {
        $result = parent::update($id, $attributes, $with, $withCount);
        ClearCacheEvent::dispatch(EziWebRemoteCacheTypeEnum::COMPANY_INFORMATION);
        return $result;
    }

    public function delete($id, $with = [])
    {
        $result = parent::delete($id, $with = []);
        ClearCacheEvent::dispatch(EziWebRemoteCacheTypeEnum::COMPANY_INFORMATION);
        return $result;
    }

}