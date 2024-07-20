<?php

namespace App\Business\Concrete;
use App\Business\Abstract\IMenuService;
use App\Core\Utilities\Results\ErrorDataResult;
use App\Core\Utilities\Results\IDataResult;
use App\Core\Utilities\Results\SuccessDataResult;
use App\DataAccess\Abstract\IMenuDal;

class MenuManager extends ServiceManager implements IMenuService
{
    private IMenuDal $menuDal;

    public function __construct(IMenuDal $menuDal)
    {
        $this->menuDal=$menuDal;
        parent::__construct($menuDal,[]);
    }

    public function GetAllByCategoryId(int $categoryId):IDataResult
    {
        $data=$this->menuDal->GetAllByCategoryId($categoryId);
        if($data) {
            return new SuccessDataResult($data,"");
        }
        return new ErrorDataResult(null,"");
    }

}
