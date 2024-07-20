<?php

namespace App\Business\Concrete;

use App\Business\Abstract\ICustomerService;
use App\Core\Utilities\Results\ErrorDataResult;
use App\Core\Utilities\Results\IDataResult;
use App\Core\Utilities\Results\SuccessDataResult;
use App\DataAccess\Abstract\ICustomerDal;

class CustomerManager extends ServiceManager implements ICustomerService
{
    private ICustomerDal $customerDal;

    public function __construct(ICustomerDal $customerDal)
    {
        $this->customerDal=$customerDal;
        parent::__construct($customerDal,[]);
    }

    public function Search(string $search,int $start,int $limit): IDataResult
    {
        $data['customer']=$this->customerDal->CustomerSearch($search,$start,$limit);
        $data['count']=$this->customerDal->CustomerSearchCount($search);
        if($data) {
            return new SuccessDataResult($data,'');
        }
        return new ErrorDataResult($data,'');
    }


}
