<?php

namespace App\Core\Utilities\Results;

class DataResult extends Result implements IDataResult
{
    protected $Data;

    public function __construct($data,bool $status,string $message)
    {
        $this->Data=$data;
        parent::__construct($status,$message);
    }

    public function Data()
    {
        return $this->Data;
    }

}
