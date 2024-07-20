<?php

namespace App\Business\Concrete;
use App\Business\Abstract\ISalonTypeService;
use App\Business\Constants\Abstract\IMessage;
use App\DataAccess\Abstract\ISalonTypeDal;

class SalonTypeManager extends ServiceManager implements ISalonTypeService
{
    private ISalonTypeDal $salonTypeDal;
    private IMessage $message;

    public function __construct(ISalonTypeDal $salonTypeDal,IMessage $message)
    {
        $this->message = $message;
        $this->salonTypeDal = $salonTypeDal;
        parent::__construct($salonTypeDal,[]);
    }

}
