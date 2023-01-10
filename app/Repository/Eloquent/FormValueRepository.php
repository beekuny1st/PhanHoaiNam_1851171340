<?php

namespace App\Repository\Eloquent;


use App\Common\EloquentRepository;
use App\Models\FormValue;
use App\Repository\FormValueRepositoryInterface;

class FormValueRepository extends EloquentRepository implements FormValueRepositoryInterface
{
    public function getModel()
    {
        return FormValue::class;
    }

}