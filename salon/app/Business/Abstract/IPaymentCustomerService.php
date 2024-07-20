<?php

namespace App\Business\Abstract;

use App\Core\Utilities\Results\IDataResult;
use App\Core\Utilities\Results\IResult;

interface IPaymentCustomerService extends IService
{
    public function GetExtre(int $cariId,int $offset,int $limit):IDataResult;  // Cari Extre
    public function CustomerPayment(array $payment,array $income,array $safe):IResult; // Cari Tahsilat
    public function TransferRecord(array $transfer):IResult; // Cari Hesap Devir Kaydı move=1 Cari Alacağı move=2 Cari Borcu
    public function BalanceUpdate(int $cariId):void;
    public function CustomerPaymentDelete(int $paymentId):IResult;
    public function CustomerDebt(array $payment,array $safe,array $expense):IResult; // Cari Ödeme
}
