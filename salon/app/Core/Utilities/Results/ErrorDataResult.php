<?php

namespace App\Core\Utilities\Results;

class ErrorDataResult extends DataResult
{
    public function __construct($data,string $message)
    {
        parent::__construct($data,false,$message);
    }
}
