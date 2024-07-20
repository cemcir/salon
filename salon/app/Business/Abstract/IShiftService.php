<?php

namespace App\Business\Abstract;

use App\Core\Utilities\Results\IDataResult;
use App\Core\Utilities\Results\IResult;

interface IShiftService extends IService
{
    public function Active():IDataResult;
    public function Calculator(int $shiftId);
    public function Close():IResult;
    public function Summar():IDataResult;
    public function Start():IResult;
}
