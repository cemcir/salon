<?php

namespace App\Business\Concrete;

use App\Business\Abstract\IPaymentCustomerService;
use App\Business\Abstract\IShiftService;
use App\Business\Constants\Abstract\IMessage;
use App\Core\Utilities\Results\ErrorDataResult;
use App\Core\Utilities\Results\ErrorResult;
use App\Core\Utilities\Results\IDataResult;
use App\Core\Utilities\Results\IResult;
use App\Core\Utilities\Results\SuccessDataResult;
use App\Core\Utilities\Results\SuccessResult;
use App\DataAccess\Abstract\ICustomerDal;
use App\DataAccess\Abstract\IExpenseDal;
use App\DataAccess\Abstract\IncomeDal;
use App\DataAccess\Abstract\IPaymentCustomerDal;
use App\DataAccess\Abstract\IPaymentDal;
use App\DataAccess\Abstract\ISafeDal;
use App\DataAccess\Abstract\IShiftDal;
use Illuminate\Support\Facades\DB;

// cari tahsilat
class PaymentCustomerManager extends ServiceManager implements IPaymentCustomerService
{
    private IMessage $message;
    private ISafeDal $safeDal;
    private IShiftDal $shiftDal;
    private IncomeDal $incomeDal;
    private IPaymentDal $paymentDal;
    private IExpenseDal $expenseDal;
    private ICustomerDal $customerDal;
    private IShiftService $shiftService;
    private IPaymentCustomerDal $paymentCustomerDal;

    public function __construct(IShiftService $shiftService,ICustomerDal $customerDal,IPaymentDal $paymentDal,IExpenseDal $expenseDal,IMessage $message,ISafeDal $safeDal,IncomeDal $incomeDal,IShiftDal $shiftDal,IPaymentCustomerDal $paymentCustomerDal)
    {
        $this->safeDal=$safeDal;
        $this->message=$message;
        $this->shiftDal=$shiftDal;
        $this->incomeDal=$incomeDal;
        $this->expenseDal=$expenseDal;
        $this->paymentDal=$paymentDal;
        $this->customerDal=$customerDal;
        $this->shiftService=$shiftService;
        $this->paymentCustomerDal=$paymentCustomerDal;
        parent::__construct1($paymentCustomerDal,$shiftDal,[]);
    }

    // nakit ,kredi kartı ,havale
    public function CustomerPayment(array $payment,array $income,array $safe): IResult
    {
        $payment['hareket']=1;

        $payment['vardiya_id']=$this->shiftId;
        $income['vardiya_id']=$this->shiftId;
        $safe['vardiya_id']=$this->shiftId;

        try {
            DB::beginTransaction();
            $paymentId=$this->paymentCustomerDal->LastInsertID($payment); // cari tahsilat ekle
            $income['cari_tahsilat_id']=$paymentId;
            $safe['cari_tahsilat_id']=$paymentId;
            $this->incomeDal->Add($income); // gelir ekle
            $this->safeDal->Add($safe); // kasaya ekle
            $this->shiftService->Calculator($payment['vardiya_id']); // vardiya hesapla ve güncelle
            $this->BalanceUpdate($payment['carikart_id']); // cari bakiye hesapla ve güncelle

            DB::commit();
            return new SuccessResult($this->message->PaymentCustomerAdded());
        }
        catch (\Exception $ex) {
            DB::rollBack();
            return new ErrorResult($ex->getMessage());
        }
    }

    // bakiye 0 dan küçükse ödenecek büyükse tahsil edilecek demektir
    private function Balance(int $cariId):float // cari bakiye hesaplar
    {
        $data['spend']=$this->paymentCustomerDal->TotalSpend($cariId); // toplam borç
        $data['payment']=$this->paymentCustomerDal->TotalPayment($cariId); // toplam tahsilat

        return $data['spend']-$data['payment']; // borç - alacak
    }

    public function GetExtre(int $cariId,int $offset,int $limit): IDataResult // Cari Extre
    {
        $data['payment']=$this->paymentCustomerDal->GetExtre($cariId,$offset,$limit);
        $data['count']=$this->paymentCustomerDal->GetExtreCount($cariId);
        $data['balance']=$this->Balance($cariId);

        if($data) {
            return new SuccessDataResult($data,'');
        }
        return new ErrorDataResult($data,$this->message->CustomerExtreNotFound());
    }

    // hareket 1 cari alacağı 2 cari borcu
    public function TransferRecord(array $transfer): IResult // Cari Devir Kaydı
    {
        $transfer['vardiya_id']=$this->shiftId;
        try {
            DB::beginTransaction();
            $this->paymentCustomerDal->Add($transfer);
            $this->BalanceUpdate($transfer['carikart_id']);
            DB::commit();

            return new SuccessResult($this->message->PaymentCustomerAdded());
        }
        catch (\Exception $ex) {
            DB::rollBack();
            return new ErrorResult($ex->getMessage());
        }
    }

    public function BalanceUpdate(int $cariId): void // cari bakiye günceller
    {
        $balance=$this->Balance($cariId);
        $this->customerDal->Update(['bakiye'=>$balance],$cariId);
    }

    public function CustomerPaymentDelete(int $paymentId): IResult
    {
        $payment=$this->paymentCustomerDal->Get($paymentId);
        if($payment) {
            try {
                DB::beginTransaction();
                $this->paymentCustomerDal->Delete($paymentId);
                if($payment->tahsilatTuru!=4 && $payment->hareket==2) { // cari ödeme mi kontrol et
                    $this->safeDal->DeleteByPaymentId($paymentId); // kasadan sil
                    $this->expenseDal->DeleteByPaymentId($paymentId); // gider tablosundan sil
                }
                else if($payment->tahsilatTuru==4) { // Açık Hesap mı Kontrol Et
                    if($this->paymentDal->Get($payment->tahsilat_id)) {
                        $this->paymentDal->Delete($payment->tahsilat_id);
                    }
                }
                else {
                    $this->safeDal->DeleteByPaymentId($paymentId); // kasadan sil
                    $this->incomeDal->DeleteByPaymentId($paymentId); // gelir tablosundan sil
                }

                $this->BalanceUpdate($payment->carikart_id); // cari bakiye güncelle
                $this->shiftService->Calculator($this->shiftId); // vardiya güncelle
                DB::commit();

                return new SuccessResult($this->message->PaymentCustomerDeleted());
            }
            catch (\Exception $ex) {
                DB::rollBack();
                return new ErrorResult($ex->getMessage());
            }
        }
        return new ErrorResult($this->message->PaymentCustomerNotFound());
    }

    // hareket 2 cari ödeme  tahsilat türü 1=nakit, 2=kredi kartı, 3=havale
    public function CustomerDebt(array $payment,array $safe,array $expense): IResult // Cari Ödeme
    {
        try {
            DB::beginTransaction();
            $payment['vardiya_id']=$this->shiftId;
            $safe['vardiya_id']=$this->shiftId;
            $safe['islemTuru']=2; // işlem turu 1 gelir 2 gider
            $expense['vardiya_id']=$this->shiftId;

            $paymentId=$this->paymentCustomerDal->LastInsertID($payment); // cari tahsilata ekle
            $safe['cari_tahsilat_id']=$paymentId;
            $expense['cari_tahsilat_id']=$paymentId; // cari ödeme id bilgisi
            $this->expenseDal->Add($expense); // gider tablosuna ekle
            $this->safeDal->Add($safe); // gideri kasaya ekle
            $this->shiftService->Calculator($this->shiftId); // vardiya hesapla ve güncelle
            $this->BalanceUpdate($payment['carikart_id']); // cari bakiye hesapla ve güncelle

            DB::commit();
            return new SuccessResult($this->message->CustomerDebtAdded());
        }
        catch (\Exception $ex) {
            DB::rollBack();
            return new ErrorResult($ex->getMessage());
        }
    }

}
