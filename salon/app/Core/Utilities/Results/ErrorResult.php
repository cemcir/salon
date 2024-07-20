<?php

namespace App\Core\Utilities\Results;

class ErrorResult extends Result
{
    public function __construct(string $message)
    {
        parent::__construct(false,$message);
    }

}
