<?php

namespace App\DataAccess\Concrete\Eloquent;

use App\Core\DataAccess\Eloquent\EloquentRepositoryBase;
use App\DataAccess\Abstract\IncomeDal;
use App\Models\Income;

class ElIncomeDal extends EloquentRepositoryBase implements IncomeDal
{
    public function __construct(Income $income)
    {
        parent::__construct($income);
    }

    public function DeleteByPaymentId(int $paymentId)
    {
        return Income::where('cari_tahsilat_id',$paymentId)->delete();
    }

}
