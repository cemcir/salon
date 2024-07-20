<?php

namespace App\DataAccess\Concrete\Eloquent;

use App\Core\DataAccess\Eloquent\EloquentRepositoryBase;
use App\DataAccess\Abstract\IShiftDal;
use App\Models\Shift;
use Illuminate\Database\Eloquent\Model;

class ElShiftDal extends EloquentRepositoryBase implements IShiftDal
{
    public function __construct(Shift $shift)
    {
        parent::__construct($shift);
    }

    public function Active():?Model // Aktif Olan Vardiyayı Getirir
    {
        return $this->WhereClause([['durum','1']]);
    }

}
