<?php

namespace App\Repository\Eloquent;


use App\Common\EloquentRepository;
use App\Models\Voucher;
use App\Repository\VoucherRepositoryInterface;

class VoucherRepository extends EloquentRepository implements VoucherRepositoryInterface
{
    public function getModel()
    {
        return Voucher::class;
    }

}