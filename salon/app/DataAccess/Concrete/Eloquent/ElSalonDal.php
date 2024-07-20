<?php

namespace App\DataAccess\Concrete\Eloquent;

use App\Core\DataAccess\Eloquent\EloquentRepositoryBase;
use App\DataAccess\Abstract\ISalonDal;
use App\Models\Salon;

class ElSalonDal extends EloquentRepositoryBase implements ISalonDal
{
    public function __construct(Salon $salon)
    {
        parent::__construct($salon);
    }

    public function GetBySalonTypeId(int $id)
    {
        return Salon::where('salonTurID',$id)->first();
    }

    public function whereLike($firmaKodu,$search)
    {
        // SELECT * FROM salon WHERE firmaKodu='".$firmaKodu."'
        // AND (salonAdi LIKE '%'.$search.'%' OR salonTurID LIKE '%'.$search.'%')

        return Salon::where('firmaKodu','=',$firmaKodu)
               ->where(function ($query) use ($search) {
                   $query->where('salonAdi','like','%'.$search.'%')
                         ->orWhere('salonTurID','like','%'.$search.'%');
               })->get();
    }

    public function WhereInClause(string $kolon,array $conditions)
    {
        return Salon::whereIn('salonID',$conditions)->get();
    }

    public function SalonExist(string $salonName)
    {
        return $this->WhereClause([['salonAdi','=',$salonName]]);
    }

}
