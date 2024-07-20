<?php

namespace App\Business\Abstract;
use App\Core\Utilities\Results\IResult;

interface IExpenseService extends IService
{
    public function ExpenseAdd(array $expense,array $safe):IResult; // Gider Ekler
}
