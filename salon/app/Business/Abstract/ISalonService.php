<?php

namespace App\Business\Abstract;

use App\Core\Utilities\Results\IDataResult;
use App\Core\Utilities\Results\IResult;
use Illuminate\Http\Request;

interface ISalonService extends IService
{
    public function GetBySalonTypeId($id):IDataResult;
}
