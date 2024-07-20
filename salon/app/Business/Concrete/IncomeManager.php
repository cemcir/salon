<?php

namespace App\Business\Concrete;

use App\Business\Abstract\IncomeService;
use App\Core\DataAccess\IEloquentRepository;
use App\DataAccess\Abstract\IncomeDal;

class IncomeManager extends ServiceManager implements IncomeService
{
    private IncomeDal $incomeDal;

    public function __construct(IncomeDal $incomeDal)
    {
        parent::__construct($incomeDal,[]);
    }


}
