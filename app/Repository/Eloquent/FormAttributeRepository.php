<?php

namespace App\Repository\Eloquent;


use App\Common\EloquentRepository;
use App\Models\FormAttribute;
use App\Repository\FormAttributeRepositoryInterface;

class FormAttributeRepository extends EloquentRepository implements FormAttributeRepositoryInterface
{
    public function getModel()
    {
        return FormAttribute::class;
    }

}