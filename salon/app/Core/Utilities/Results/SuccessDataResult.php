<?php

namespace App\Core\Utilities\Results;

class SuccessDataResult extends DataResult
{
    public function __construct($data,string $message)
    {
        parent::__construct($data,true,$message);
    }
}
