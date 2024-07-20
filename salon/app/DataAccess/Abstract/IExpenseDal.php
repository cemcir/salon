<?php

namespace App\DataAccess\Abstract;

use App\Core\DataAccess\IEloquentRepository;
use Illuminate\Database\Eloquent\Collection;

interface IExpenseDal extends IEloquentRepository
{
    public function _GetAllByLimit($start,$end):Collection;
    public function DeleteByPaymentId(int $paymentId);
}
