<?php

namespace App\DataAccess\Abstract;
use App\Core\DataAccess\IEloquentRepository;

interface ISafeDal extends IEloquentRepository
{
    public function DeleteByPaymentId(int $paymentId);
}
