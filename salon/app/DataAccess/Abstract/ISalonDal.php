<?php

namespace App\DataAccess\Abstract;

use App\Core\DataAccess\IEloquentRepository;

interface ISalonDal extends IEloquentRepository
{
    public function GetBySalonTypeId(int $id);
    public function whereLike($firmaKodu,$search);
    public function WhereInClause(string $kolon,array $conditions);
    public function SalonExist(string $salonName);
}
