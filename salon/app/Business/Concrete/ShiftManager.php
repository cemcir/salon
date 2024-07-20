<?php

namespace App\Business\Concrete;

use App\Business\Abstract\IShiftService;
use App\Business\Constants\Abstract\IMessage;
use App\Core\Utilities\Results\ErrorDataResult;
use App\Core\Utilities\Results\ErrorResult;
use App\Core\Utilities\Results\IDataResult;
use App\Core\Utilities\Results\IResult;
use App\Core\Utilities\Results\SuccessDataResult;
use App\Core\Utilities\Results\SuccessResult;
use App\DataAccess\Abstract\IExpenseDal;
use App\DataAccess\Abstract\IncomeDal;
use App\DataAccess\Abstract\IPaymentCustomerDal;
use App\DataAccess\Abstract\IPaymentDal;
use App\DataAccess\Abstract\IShiftDal;
use Illuminate\Support\Facades\DB;

class ShiftManager extends ServiceManager implements IShiftService
{
    private IMessage $message;
    private IShiftDal $shiftDal;
    private IncomeDal $incomeDal;
    private IExpenseDal $expenseDal;
    private IPaymentDal $paymentDal;
    private IPaymentCustomerDal $paymentCustomerDal;

    public function __construct(IShiftDal $shiftDal,IncomeDal $incomeDal,IExpenseDal $expenseDal,IPaymentDal $paymentDal,IPaymentCustomerDal $paymentCustomerDal,IMessage $message)
    {
        $this->message=$message;
        $this->shiftDal=$shiftDal;
        $this->incomeDal=$incomeDal;
        $this->expenseDal=$expenseDal;
        $this->paymentDal=$paymentDal;
        parent::__construct($shiftDal,[]);
        $this->paymentCustomerDal=$paymentCustomerDal;
    }

    public function Active():IDataResult
    {
        $data=$this->shiftDal->Active();
        if($data) {
            return new SuccessDataResult($data,'');
        }
        return new ErrorDataResult([],'');
    }

    // cari tahsilat = açık hesap değilse ve hareket = 1 ise
    public function Calculator(int $shiftId) // Vardiya Hesabını Yapar
    {
        $data['ciro']=$this->paymentDal->TotalPrice('tutar',[['vardiya_id',$shiftId]]);
        $data['cariTahsilat']=$this->paymentCustomerDal->TotalPrice('tutar',[['vardiya_id',$shiftId],['tahsilatTuru','<>',4],['hareket',1]]);
        $data['gelir']=$this->incomeDal->TotalPrice('tutar',[['vardiya_id',$shiftId]]);
        $data['gider']=$this->expenseDal->TotalPrice('tutar',[['vardiya_id',$shiftId]]);
        $data['nakitGelir']=$this->incomeDal->TotalPrice('tutar',[['vardiya_id',$shiftId],['tahsilatTuru',1]]);
        $data['nakitGider']=$this->expenseDal->TotalPrice('tutar',[['vardiya_id',$shiftId],['tahsilatTuru',1]]);
        $data['nakit']=$this->incomeDal->TotalPrice('tutar',[['vardiya_id',$shiftId],['tahsilatTuru',1]]); // toplam nakit gelir
        $data['krediKarti']=$this->incomeDal->TotalPrice('tutar',[['vardiya_id',$shiftId],['tahsilatTuru',2]]); // toplam kredi kartı geliri
        $data['havale']=$this->incomeDal->TotalPrice('tutar',[['vardiya_id',$shiftId],['tahsilatTuru',3]]); // toplam havale geliri
        $data['netKasa']=$data['nakitGelir']-$data['nakitGider'];
        $data['netKar']=$data['gelir']-$data['gider'];

        $this->shiftDal->Update($data,$shiftId);
    }

    public function Close():IResult // vardiya kapattığında yeni vardiya otomatik başlayacak
    {
        $shift=$this->shiftDal->Active();
        if($shift) {
            try {
                DB::beginTransaction();
                $date=date('Y-m-d H:i:s');
                $this->shiftDal->Update(['durum'=>0,'bitisTarih'=>$date],$shift->id);
                $this->shiftDal->Add(['durum'=>1,'baslangicTarih'=>$date]);
                DB::commit();

                return new SuccessResult($this->message->ShiftClosed());
            }
            catch (\Exception $ex) {
                DB::rollBack();
                return new ErrorResult($this->message->ShiftNotClosed());
            }
        }
        return new ErrorResult($this->message->ShiftNotFound());
    }

    public function Summar(): IDataResult // vardiya özeti
    {
        $data=$this->shiftDal->Active();
        if($data) {
            return new SuccessDataResult($data,'');
        }
        return new ErrorDataResult(null,$this->message->ShiftNotFound());
    }

    public function Start(): IResult // Yeni Vardiyayı Başlatacak
    {
        if(!$this->shiftDal->Active()) { // Aktif Vardiya Yoksa
            if($this->shiftDal->Add(['baslangicTarih'=>date('Y-m-d')])) { // Yeni Vardiya Başlat
                return new SuccessResult('');
            }
            return new ErrorResult('');
        }
        return new SuccessResult('');
    }

}
