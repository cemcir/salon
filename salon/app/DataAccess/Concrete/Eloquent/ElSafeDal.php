<?php

namespace App\DataAccess\Concrete\Eloquent;
use App\Core\DataAccess\Eloquent\EloquentRepositoryBase;
use App\DataAccess\Abstract\ISafeDal;
use App\Models\Safe;

class ElSafeDal extends EloquentRepositoryBase implements ISafeDal
{
    public function __construct(Safe $safe)
    {
        parent::__construct($safe);
    }

    public function DeleteByPaymentId(int $paymentId)
    {
        return Safe::where('cari_tahsilat_id',$paymentId)->delete();
    }

}
