<?php

namespace App\DataAccess\Abstract;

use App\Core\DataAccess\IEloquentRepository;

interface IPaymentDal extends IEloquentRepository
{
    public function TotalPayment(int $rezervationID);
    public function GetByRezervationId(int $rezervationId);
}
