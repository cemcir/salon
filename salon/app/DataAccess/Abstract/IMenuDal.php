<?php

namespace App\DataAccess\Abstract;
use App\Core\DataAccess\IEloquentRepository;

interface IMenuDal extends IEloquentRepository
{
    public function TotalMenuPrice(array $menuId);
    public function GetAllByCategoryId(int $categoryId); // kategoriye ait menüleri getir
}
