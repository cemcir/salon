<?php

namespace App\Business\Abstract;

use App\Core\Utilities\Results\IResult;

interface IUserService extends IService
{
    public function UserUpdate($user,$image):IResult;
}
