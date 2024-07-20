<?php

namespace App\Core\Utilities\Results;

class SuccessResult extends Result
{
    public function __construct(string $message)
    {
        parent::__construct(true,$message);
    }
}
