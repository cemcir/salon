<?php

namespace App\DataAccess\Concrete\Eloquent;

use App\Core\DataAccess\Eloquent\EloquentRepositoryBase;
use App\DataAccess\Abstract\ISalonTypeDal;
use App\Models\SalonType;

class ElSalonTypeDal extends EloquentRepositoryBase implements ISalonTypeDal
{
    public function __construct(SalonType $salonType)
    {
        parent::__construct($salonType);
    }
}
