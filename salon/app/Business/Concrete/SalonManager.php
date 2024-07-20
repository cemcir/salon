<?php

namespace App\Business\Concrete;

use App\Business\Abstract\ISalonService;
use App\Business\Constants\Abstract\IMessage;
use App\Core\Utilities\Results\ErrorResult;
use App\Core\Utilities\Results\IDataResult;
use App\Core\Utilities\Results\SuccessDataResult;
use App\Core\Utilities\Results\SuccessResult;
use App\DataAccess\Abstract\ISalonDal;

class SalonManager extends ServiceManager implements ISalonService
{
    private ISalonDal $salonDal;
    private IMessage $message;

    public function __construct(ISalonDal $salonDal,IMessage $message)
    {
        $this->message=$message;
        $this->salonDal=$salonDal;
        parent::__construct($salonDal,[]);
    }

    private function CheckIfSalonNameAlreadyExist($salonName) {
        if($this->salonDal->SalonExist($salonName)) {
            return new ErrorResult($this->message->SalonAlreadyExist());
        }
        return new SuccessResult("");
    }

    public function GetBySalonTypeId($id): IDataResult
    {
        return new SuccessDataResult(null,'');
    }

}
