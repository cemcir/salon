<?php

namespace App\DataAccess\Concrete\Eloquent;

use App\Core\DataAccess\Eloquent\EloquentRepositoryBase;
use App\DataAccess\Abstract\IPaymentDal;
use App\Models\Payment;

class ElPaymentDal extends EloquentRepositoryBase implements IPaymentDal
{
    public function __construct(Payment $payment)
    {
        parent::__construct($payment);
    }

    public function TotalPayment(int $rezervationID)
    {
        return $this->TotalPrice('tutar',[['rezervasyon_id','=',$rezervationID]]);
    }

    public function GetByRezervationId(int $rezervationId) // rezervasyon id ile tahsilat kaydı getir
    {
        return Payment::where('rezervasyon_id',$rezervationId)->first();
    }
}
