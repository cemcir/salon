<?php

namespace App\Business\Concrete;

use App\Business\Abstract\IPaymentService;
use App\Business\Abstract\IRezervationService;
use App\Business\Constants\Abstract\IMessage;
use App\Core\Utilities\Business\BusinessRules;
use App\Core\Utilities\Results\ErrorDataResult;
use App\Core\Utilities\Results\ErrorResult;
use App\Core\Utilities\Results\IDataResult;
use App\Core\Utilities\Results\IResult;
use App\Core\Utilities\Results\SuccessDataResult;
use App\Core\Utilities\Results\SuccessResult;
use App\DataAccess\Abstract\IMenuCategoryDal;
use App\DataAccess\Abstract\IMenuDal;
use App\DataAccess\Abstract\IPaymentDal;
use App\DataAccess\Abstract\IRezervationDal;
use App\DataAccess\Abstract\IRezervationMenuDal;
use Illuminate\Support\Facades\DB;

class RezervationManager extends ServiceManager implements IRezervationService
{
    private IMessage $message;
    private IMenuDal $menuDal;
    private IPaymentDal $paymentDal;
    private IPaymentService $paymentService;
    private IRezervationDal $rezervationDal;
    private IMenuCategoryDal $menuCategoryDal;
    private IRezervationMenuDal $rezervationMenuDal;

    public function __construct(IPaymentService $paymentService,IPaymentDal $paymentDal,IMenuDal $menuDal,IRezervationMenuDal $rezervationMenuDal,IMenuCategoryDal $menuCategoryDal,IRezervationDal $rezervationDal,IMessage $message)
    {
        $this->message=$message;
        $this->menuDal=$menuDal;
        $this->paymentDal=$paymentDal;
        $this->rezervationDal=$rezervationDal;
        $this->paymentService=$paymentService;
        $this->menuCategoryDal=$menuCategoryDal;
        $this->rezervationMenuDal=$rezervationMenuDal;
        parent::__construct($this->rezervationDal,[]);
    }

    public function Search($start,$end,$date,$offset,$limit): IDataResult
    {
        $data['rezervation']=$this->rezervationDal->_Search($start,$end,$date,$offset,$limit);
        if(count($data)>0) {
            $data['totalRecord']=$this->rezervationDal->_TotalRecord($start,$end,$date);
            return new SuccessDataResult($data,"");
        }
        return new ErrorDataResult([],"");
    }

    public function TotalRecord($start,$end,$date):IDataResult
    {
        $data=$this->rezervationDal->_TotalRecord($start,$end,$date);
        if(count($data)>0) {
            return new SuccessDataResult($data,"");
        }
        return new ErrorDataResult([],"");
    }

    public function RezervationUpdate(array $rezervation): IDataResult // Rezervasyonu Güncellemek İçin Kullanılır
    {
        $result=BusinessRules::Run([$this->CheckIfRezervationAlreadyExist($rezervation)]);
        if($result!=null) {
            return $result;
        }
        $data=$this->rezervationDal->Get($rezervation['rezervasyonId']);
        if($data) {
            try {
                DB::beginTransaction();
                $this->rezervationDal->Update($rezervation, $rezervation['rezervasyonId']);
                $result=$this->paymentService->PaymentState($data['id'],$data['menuTutari'],$rezervation['kiraTutari']);
                DB::commit();
                return new SuccessDataResult($result->Data(),$this->message->RezervationUpdate());
            }
            catch (\Exception $ex) {
                DB::rollBack();
                return new ErrorDataResult(null, $ex->getMessage());
            }
        }

        return new ErrorDataResult(null,$this->message->RezervationNotFound());
    }

    public function RezervationGetAllByLimit($start,$end): IDataResult
    {
        $data=$this->rezervationDal->_GetAllByLimit($start,$end);
        if($data) {
            return new SuccessDataResult($data,"");
        }
        return new ErrorDataResult(null,"");
    }

    // rezervasyon bilgisi rezervasyona ait menüler ve menü kategorileri
    public function GetRezervation(int $rezervationID):IDataResult
    {
        $data['rezervation']=$this->rezervationDal->Get($rezervationID);
        if($data['rezervation']) {
            $data['menu'] = $this->rezervationDal->GetMenuByRezervationId($rezervationID);
            $data['kategori'] = $this->menuCategoryDal->GetAll();
            return new SuccessDataResult($data,"");
        }
        return new ErrorDataResult(null,$this->message->RezervationNotFound());
    }

    // aynı tarihte ve saatler arasında rezervasyon var mı kontrol et
    public function CheckIfRezervationAlreadyExist(array $rezervation):IResult
    {
//        DB::table('rezervation')
//            ->where('girisSaat','<',$rezervation['end'])
//            ->where('cikisSaat','>',$rezervation['start'])
//            ->where('rezervasyonTarih','=',$rezervation['rezervasyonTarih'])
//            ->first();

        if($this->rezervationDal->_Control($rezervation['girisSaat'],$rezervation['cikisSaat'],$rezervation['rezervasyonTarih'])) {
            return new ErrorResult($this->message->RezervationAlreadyExist());
        }
        return new SuccessResult('');
    }

    public function RezervationDelete(int $rezervationId): IResult
    {
        // Rezervasyona Ait Tahsilat Kaydı Var mı ?
        // Rezervasyona Ait Menu Kaydı Var mı ?
        $result=BusinessRules::Run([$this->CheckIfPaymentAlreadyExist($rezervationId),
                                    $this->CheckIfMenuAlreadyExist($rezervationId)]);
        if($result!=null) {
            return $result;
        }

        if($this->rezervationDal->Get($rezervationId)) {
            if($this->rezervationDal->Delete($rezervationId)) {
                return new SuccessResult($this->message->RezervationDeleted());
            }
            return new ErrorResult($this->message->RezervationNotDeleted());
        }
        return new ErrorResult($this->message->RezervationNotFound());
    }

    private function CheckIfPaymentAlreadyExist(int $rezervationId):IResult // Tahsilat Kaydı İçin İş Kuralı
    {
        if($this->paymentDal->GetByRezervationId($rezervationId)) {
            return new ErrorResult($this->message->PaymentAlreadyExist());
        }
        return new SuccessResult('');
    }

    private function CheckIfMenuAlreadyExist(int $rezervationId):IResult
    {
        if($this->rezervationMenuDal->GetByRezervationId($rezervationId)) {
            return new ErrorResult($this->message->MenuAlreadyExist());
        }
        return new SuccessResult('');
    }

    public function GetByMonthNow():IDataResult
    {
        $data=$this->rezervationDal->GetAllByMonthNow();
        if($data) {
            return new SuccessDataResult($data,'');
        }
        return new ErrorDataResult(null,'');
    }

    public function GetByMonthAndYear($month,$year): IDataResult
    {
        $data=$this->rezervationDal->GetByMonthAndYear($month,$year);
        if($data) {
            return new SuccessDataResult($data,'');
        }
        return new ErrorDataResult(null,'');
    }

}
