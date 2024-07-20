<?php

namespace App\Business\Concrete;
use App\Business\Abstract\IService;
use App\Core\DataAccess\IEloquentRepository;
use App\Core\Utilities\Business\BusinessRules;
use App\Core\Utilities\Constants\Concrete\TurkishMessage;
use App\Core\Utilities\Results\ErrorDataResult;
use App\Core\Utilities\Results\ErrorResult;
use App\Core\Utilities\Results\IDataResult;
use App\Core\Utilities\Results\IResult;
use App\Core\Utilities\Results\SuccessDataResult;
use App\Core\Utilities\Results\SuccessResult;
use App\DataAccess\Abstract\IShiftDal;

class ServiceManager implements IService
{
    protected int $shiftId=0;
    private array $baseLogics;
    private IShiftDal $shiftDal;
    private IEloquentRepository $dal;

    public function __construct(IEloquentRepository $dal,array $baseLogics)
    {
        $this->dal=$dal;
        $this->baseLogics=$baseLogics;
    }

    // costructor method overloading
    public function __construct1(IEloquentRepository $dal,IShiftDal $shifDal,array $baseLogics):void
    {
        $this->dal=$dal;
        $this->shiftDal=$shifDal;
        $this->baseLogics=$baseLogics;
        $shift=$this->shiftDal->Active();
        if($shift) {
            $this->shiftId=$shift->id;
        }
    }

    public function GetAll(): IDataResult
    {
        $data=$this->dal->GetAll();
        if(count($data)>0) {
            return new SuccessDataResult($data,"");
        }
        return new ErrorDataResult([],"");
    }

    public function Get(int $id): IDataResult
    {
        $data=$this->dal->Get($id);
        if($data) {
            return new SuccessDataResult($data,"");
        }
        return new ErrorDataResult([],TurkishMessage::NotFound());
    }

    public function Add(array $arr,array $logics=null):IResult
    {
        if(!empty($this->baseLogics)) { // ekleme işleminde minimum kısıtlamalar için kullanılır iş kuralıdır kısaca
            $result = BusinessRules::Run($this->baseLogics);
            if ($result != null) {
                return $result;
            }
        }

        if($logics!=null) {
            $result=BusinessRules::Run($logics);
            if($result!=null) {
                return $result;
            }
        }

        if($this->dal->Add($arr)) {
            return new SuccessResult(TurkishMessage::Success());
        }
        return new ErrorResult(TurkishMessage::Error());
    }

    public function Update(array $arr,int $id,array $logics=null): IResult
    {
        if(!empty($this->baseLogics)) {
            $result = BusinessRules::Run($this->baseLogics);
            if ($result != null) {
                return $result;
            }
        }

        if($logics!=null) {
            $result = BusinessRules::Run($logics);
            if ($result != null) {
                return $result;
            }
        }

        if($this->dal->Get($id)) {
            if ($this->dal->Update($arr,$id)) {
                return new SuccessResult(TurkishMessage::Success());
            }
            return new ErrorResult(TurkishMessage::Error());
        }

        return new ErrorResult(TurkishMessage::NotFound());
    }

    public function Delete(int $id): IResult
    {
        if($this->dal->Get($id)) {
            if($this->dal->Delete($id)) {
                return new SuccessResult(TurkishMessage::Success());
            }
            return new ErrorResult(TurkishMessage::Error());
        }
        return new ErrorResult(TurkishMessage::NotFound());
    }

    public function GetAllByLimit($start,$end,$sort): IDataResult
    {
        $data['data']=$this->dal->GetAllByLimit($start,$end,$sort);
        $data['count']=$this->dal->TotalCount();
        if(count($data)>0) {
            return new SuccessDataResult($data,"");
        }
        return new ErrorDataResult([],"");
    }

    public function LastInsertID(array $arr): IDataResult
    {
        $data=$this->dal->LastInsertID($arr);
        if($data) {
            return new SuccessDataResult($data,"");
        }
        return new ErrorDataResult([],"");
    }

}
