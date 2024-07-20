<?php

namespace App\DataAccess\Abstract;
use App\Core\DataAccess\IEloquentRepository;
use Illuminate\Database\Eloquent\Model;

interface IShiftDal extends IEloquentRepository
{
    public function Active():?Model;

}
