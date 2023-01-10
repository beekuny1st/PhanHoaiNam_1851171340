<?php

namespace App\Repository\Eloquent;


use App\Common\EloquentRepository;
use App\Models\Form;
use App\Repository\FormRepositoryInterface;

class FormRepository extends EloquentRepository implements FormRepositoryInterface
{
    public function getModel()
    {
        return Form::class;
    }

}