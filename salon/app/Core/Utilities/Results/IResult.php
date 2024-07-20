<?php

namespace App\Core\Utilities\Results;

interface IResult
{
    public function Message():String;
    public function Status():bool;
}
