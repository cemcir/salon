<?php

namespace App\Business\Abstract;
use App\Core\Utilities\Results\IDataResult;

interface IPaymentService extends IService
{
    public function PaymentAdd(array $payment,array $income,array $safe,array $customer):IDataResult; // Rezervasyona Yapılan Tahsilat Kaydı İçin Kullanılır
    public function PaymentState(int $rezervationID,float $menuPrice,float $paymentPrice):IDataResult; // Rezervasyon Ödeme Durumunu Güncellemek İçin Kullanılır
    public function PaymentDelete(int $paymentID):IDataResult; // İlgili Tahsilatı Silmek İçin Kullanılır
}
