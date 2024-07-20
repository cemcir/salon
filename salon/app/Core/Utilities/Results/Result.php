<?php

namespace App\Core\Utilities\Results;

class Result implements IResult
{
    protected String $Message;
    protected bool $Status;

    public function __construct(bool $status,String $message)
    {
        $this->Status=$status;
        $this->Message=$message;
    }

    public function Message(): string
    {
        return $this->Message;
    }

    public function Status(): bool
    {
        return $this->Status;
    }

}
