<?php

namespace App\Business\Concrete;

use App\Business\Abstract\IPaymentService;
use App\Business\Abstract\IRezervationMenuService;
use App\Business\Constants\Abstract\IMessage;
use App\Core\Utilities\Business\BusinessRules;
use App\Core\Utilities\Results\ErrorDataResult;
use App\Core\Utilities\Results\ErrorResult;
use App\Core\Utilities\Results\IDataResult;
use App\Core\Utilities\Results\IResult;
use App\Core\Utilities\Results\SuccessDataResult;
use App\Core\Utilities\Results\SuccessResult;
use App\DataAccess\Abstract\IMenuDal;
use App\DataAccess\Abstract\IRezervationDal;
use App\DataAccess\Abstract\IRezervationMenuDal;
use Illuminate\Support\Facades\DB;

class RezervationMenuManager extends ServiceManager implements IRezervationMenuService
{
    private IMessage $message;
    private IMenuDal $menuDal;
    private IRezervationDal $rezervationDal;
    private IPaymentService $paymentService;
    private IRezervationMenuDal $rezervationMenuDal;

    public function __construct(IMessage $message,IMenuDal $menuDal,IRezervationMenuDal $rezervationMenuDal,IRezervationDal $rezervationDal,IPaymentService $paymentService)
    {
        $this->message=$message;
        $this->menuDal=$menuDal;
        $this->paymentService=$paymentService;
        parent::__construct($rezervationMenuDal,[]);
        $this->rezervationMenuDal=$rezervationMenuDal;
        $this->rezervationDal=$rezervationDal;
    }
    /**
     * @throws \Exception
     */

    // rezervasyona ait menüleri güncellemek için kullanılır
    public function RezervationMenuUpdate(array $menu,int $rezervationId):IDataResult
    {
        try {
            DB::beginTransaction();
            $rezervation=$this->rezervationDal->Get($rezervationId);
            if(!$rezervation) {
                return new ErrorDataResult(null,$this->message->RezervationNotFound());
            }
            if($this->rezervationMenuDal->GetByRezervationId($rezervationId)) { // rezervasyona ait menü var mı kontrol et
                $this->rezervationMenuDal->DeleteByRezervationId($rezervationId); // rezervasyona ait tüm menülerü sil
            }
            if(!empty($menu)) {
                foreach ($menu as $item) { // gelen menüleri döngü ile dön tekrar ekle
                    $item['rezervasyon_id']=$rezervationId;
                    $this->rezervationMenuDal->Add($item);
                }
            }
            $totalPrice=$this->TotalPrice($menu,$rezervation['davetli']); // toplam menü tutarını hesapla
            $this->rezervationDal->Update(['menuTutari'=>$totalPrice],$rezervationId); // rezervasyona ait menü tutarını güncelle

            $result=$this->paymentService->PaymentState($rezervationId,$totalPrice,$rezervation['kiraTutari']); // ödeme durumunu kontrol et
            DB::commit();

            return new SuccessDataResult($result->Data(),$this->message->RezervationMenuUpdated());
        }
        catch (\Exception $ex) {
            DB::rollBack();
            return new ErrorDataResult(null,$ex->getMessage());
        }
    }

    public function RezervationMenuAdd(array $rezervation,array $menu): IResult
    {
        $result=BusinessRules::Run([$this->CheckIfRezervationExist($rezervation['girisSaat'],$rezervation['cikisSaat'],$rezervation['rezervasyonTarih'])]);
        if($result!=null) {
            return $result;
        }
        try {
            DB::beginTransaction();
            $rezervationId=$this->rezervationDal->LastInsertID($rezervation);
            if(!empty($menu)) {
                foreach ($menu as $item) {
                    $item['rezervasyon_id']=$rezervationId;
                    $this->rezervationMenuDal->Add($item);
                }
            }
            $totalPrice=$this->TotalPrice($menu,$rezervation['davetli']);
            $this->rezervationDal->Update(['menuTutari'=>$totalPrice],$rezervationId);

            DB::commit();
            return new SuccessResult($this->message->RezervationMenuAdded());
        }
        catch (\Exception $ex) {
            DB::rollBack();
            return new ErrorResult($ex->getMessage());
        }
    }

    private function CheckIfRezervationExist($start,$end,$date) { // aynı tarih ve saatler arasında başka rezervasyon var mı ?

        if($this->rezervationDal->_Control($start,$end,$date)) {
            return new ErrorResult($this->message->RezervationAlreadyExist());
        }
        return new SuccessResult("");
    }

    // rezervasyona ait menü tutarını hesaplar
    public function TotalPrice(array $menu,int $guest):float // guest davetli sayısı
    {
        $totalPrice=0;
        $menuList=$this->menuDal->GetAll();
        foreach ($menu as $item) {
            foreach ($menuList as $list) {
                if($item['menu_id']==$list->id) {
                    $totalPrice=$totalPrice+($list->tutar*$guest);
                }
            }
        }
        return round($totalPrice,2);
    }

}
