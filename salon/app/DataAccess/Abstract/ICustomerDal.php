<?php

namespace App\DataAccess\Abstract;
use App\Core\DataAccess\IEloquentRepository;

interface ICustomerDal extends IEloquentRepository
{
    public function CustomerSearch(string $search,int $start,int $limit);
    public function CustomerSearchCount(string $search);
}
