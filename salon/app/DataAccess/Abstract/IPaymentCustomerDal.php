<?php

namespace App\DataAccess\Abstract;

use App\Core\DataAccess\IEloquentRepository;

interface IPaymentCustomerDal extends IEloquentRepository
{
    public function GetExtre(int $cariId,int $start,int $limit); // cari extre
    public function TotalPayment(int $cariId); // toplam tahsilat
    public function TotalSpend(int $cariId); // toplam harcama
    public function GetExtreCount(int $cariId):int; // cari extre sayısı
    public function GetByPaymentId(int $paymentId);
}
