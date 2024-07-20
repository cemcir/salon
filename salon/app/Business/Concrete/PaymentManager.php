<?php

namespace App\Business\Concrete;

use App\Business\Abstract\IPaymentCustomerService;
use App\Business\Abstract\IPaymentService;
use App\Business\Abstract\IShiftService;
use App\Business\Constants\Abstract\IMessage;
use App\Core\Utilities\Results\ErrorDataResult;
use App\Core\Utilities\Results\IDataResult;
use App\Core\Utilities\Results\SuccessDataResult;
use App\DataAccess\Abstract\ICustomerDal;
use App\DataAccess\Abstract\IncomeDal;
use App\DataAccess\Abstract\IPaymentCustomerDal;
use App\DataAccess\Abstract\IPaymentDal;
use App\DataAccess\Abstract\IRezervationDal;
use App\DataAccess\Abstract\ISafeDal;
use App\DataAccess\Abstract\IShiftDal;
use Illuminate\Support\Facades\DB;

class PaymentManager extends ServiceManager implements IPaymentService
{
    private $shift;
    private ISafeDal $safeDal;
    private IMessage $message;
    private IShiftDal $shiftDal;
    private IncomeDal $incomeDal;
    private IPaymentDal $paymentDal;
    private ICustomerDal $customerDal;
    private IShiftService $shiftService;
    private IRezervationDal $rezervationDal;
    private IPaymentCustomerDal $paymentCustomerDal;
    private IPaymentCustomerService $paymentCustomerService;

    public function __construct(IShiftService $shiftService,IPaymentCustomerService $paymentCustomerService,ICustomerDal $customerDal,IPaymentDal $paymentDal,IRezervationDal $rezervationDal,IncomeDal $incomeDal,IShiftDal $shiftDal,ISafeDal $safeDal,IPaymentCustomerDal $paymentCustomerDal,IMessage $message)
    {
        $this->message=$message;
        $this->safeDal=$safeDal;
        $this->shiftDal=$shiftDal;
        $this->incomeDal=$incomeDal;
        $this->paymentDal=$paymentDal;
        $this->customerDal=$customerDal;
        $this->shiftService=$shiftService;
        $this->rezervationDal=$rezervationDal;
        $this->shift=$this->shiftDal->Active();
        $this->paymentCustomerDal=$paymentCustomerDal;
        $this->paymentCustomerService=$paymentCustomerService;
        parent::__construct($paymentDal,[]);
    }

    //tahsilat ekleme
    public function PaymentAdd(array $payment,array $income,array $safe,array $customer):IDataResult
    {
        if(!$this->shift) {
            return new SuccessDataResult(null,$this->message->ShiftNotFound());
        }

        $payment['vardiya_id']=$this->shift->id;

        $rezervation=$this->rezervationDal->Get($payment['rezervasyon_id']);

        if($rezervation) {
            try {
                DB::beginTransaction();
                $paymentId=$this->paymentDal->LastInsertID($payment); // Tahsilat Tarafına Ekle
                $income['vardiya_id']=$payment['vardiya_id'];
                $income['tahsilat_id']=$paymentId;

                $safe['vardiya_id']=$payment['vardiya_id'];
                $safe['tahsilat_id']=$paymentId;

                // Açık Hesapsa Cari Tahsilatı Yapılmadığında Gelir Tablosuna Düşmez

                if($payment['tahsilatTuru']!=4) { // Açık Hesap Değilse
                    $this->incomeDal->Add($income); // Gelir Tablosuna Ekle
                    $this->safeDal->Add($safe); // Kasaya Ekle
                }
                else {
                    $customer['carikart_id']=$rezervation->carikart_id;
                    $customer['vardiya_id']=$payment['vardiya_id'];
                    $customer['tahsilat_id']=$paymentId;

                    $this->paymentCustomerDal->Add($customer); // Açık Hesapsa Cari Tahsilata Borcu Ekle
                    $this->paymentCustomerService->BalanceUpdate($rezervation->carikart_id); // Cari Bakiye Güncelle
                }

                $this->shiftService->Calculator($payment['vardiya_id']); // Vardiya Hesapla ve Güncelle
                $result = $this->PaymentState($payment['rezervasyon_id'],$rezervation['menuTutari'],$rezervation['kiraTutari']); // Ödeme Durumunu Kontrol Eder

                DB::commit();
                return new SuccessDataResult($result->Data(),$this->message->PaymentAdded());
            }
            catch (\Exception $e) {
                DB::rollBack();
                return new ErrorDataResult(null,$e->getMessage());
            }
        }
        return new ErrorDataResult(null,$this->message->RezervationNotFound());
    }

    // rezervasyon ödeme durumunu güncelleme için kullandık
    public function PaymentState(int $rezervationID,float $menuPrice,float $paymentPrice):IDataResult
    {
        $payment['odemeDurum']='0';

        $totalPrice=$paymentPrice+$menuPrice; // düğün salonu toplam tutarı
        $totalPayment=$this->paymentDal->TotalPayment($rezervationID); // toplam tahsilat

        if($totalPayment>=$totalPrice) { // toplam tahsilat rezervasyon tutarından fazla mı kontrol et
            $payment['odemeDurum']='1';
        }

        $remainderPrice=round($totalPrice-$totalPayment,2);
        $totalPrice=round($totalPrice,2);
        $totalPayment=round($totalPayment,2);

        $this->rezervationDal->Update($payment,$rezervationID);

        $data=['toplamTutar'=>$totalPrice,'toplamTahsilat'=>$totalPayment,'odemeDurum'=>$payment['odemeDurum'],'kalanTutar'=>$remainderPrice];
        return new SuccessDataResult($data,"");
    }

    public function PaymentDelete(int $paymentID): IDataResult // tahsilat silme işlemi
    {
        $payment=$this->paymentDal->Get($paymentID); // tahsilat var mı
        if(!$payment) {
            return new ErrorDataResult(null,$this->message->PaymentNotFound());
        }
        $rezervation=$this->rezervationDal->Get($payment['rezervasyon_id']); // tahsilata ait rezervasyon var mı
        if(!$rezervation) {
            return new ErrorDataResult(null,$this->message->RezervationNotFound());
        }
        try {
            DB::beginTransaction();
            $this->paymentDal->Delete($paymentID); // tahsilat sil

            if($payment['tahsilatTuru']==4) { // açık hesap mı kontrol et
                $customerPayment=$this->paymentCustomerDal->GetByPaymentId($paymentID); // tahsilata ait cari borcunu al
                if($customerPayment) {
                    $this->paymentCustomerDal->Delete($customerPayment->id); // cari borcu sil
                    $this->paymentCustomerService->BalanceUpdate($customerPayment->carikart_id); // cari bakiye güncelle
                }
            }
            else {
                $this->safeDal->DeleteByPaymentId($paymentID); // tahsilatı kasadan sil
                $this->incomeDal->DeleteByPaymentId($paymentID); // tahsilatı gelirden sil
            }

            $this->shiftService->Calculator($payment['vardiya_id']); // Vardiya Hesapla ve Güncelle
            $result=$this->PaymentState($rezervation->id,$rezervation['menuTutari'],$rezervation['kiraTutari']); // Ödeme Durumunu Kontrol Et
            DB::commit();

            return new SuccessDataResult($result->Data(),$this->message->PaymentDeleted());
        }
        catch (\Exception $ex) {
            DB::rollBack();
            return new ErrorDataResult(null,$ex->getMessage());
        }
    }

}
