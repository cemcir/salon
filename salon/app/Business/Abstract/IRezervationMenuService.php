<?php

namespace App\Business\Abstract;

use App\Core\Utilities\Results\IDataResult;
use App\Core\Utilities\Results\IResult;

interface IRezervationMenuService extends IService
{
    public function RezervationMenuAdd(array $rezervation,array $menu):IResult;
    public function RezervationMenuUpdate(array $menu,int $rezervationId):IDataResult;
}
