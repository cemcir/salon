<?php

namespace App\DataAccess\Abstract;

use App\Core\DataAccess\IEloquentRepository;

interface IncomeDal extends IEloquentRepository
{
    public function DeleteByPaymentId(int $paymentId);
}
