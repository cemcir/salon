<?php

namespace App\Business\Abstract;
use App\Core\Utilities\Results\IDataResult;

interface ICustomerService extends IService
{
    public function Search(string $search,int $start,int $limit):IDataResult;
}
