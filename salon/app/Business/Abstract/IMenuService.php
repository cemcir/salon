<?php

namespace App\Business\Abstract;

use App\Core\Utilities\Results\IDataResult;

interface IMenuService extends IService
{
    public function GetAllByCategoryId(int $categoryId):IDataResult;
}
