<?php

namespace App\DataAccess\Concrete\Eloquent;

use App\Core\DataAccess\Eloquent\EloquentRepositoryBase;
use App\DataAccess\Abstract\IRezervationDal;
use App\Models\Rezervation;

class ElRezervationDal extends EloquentRepositoryBase implements IRezervationDal
{
    public function __construct(Rezervation $rezervation)
    {
        parent::__construct($rezervation);
    }

    public function _Control($start,$end,$date)
    {
        return $this->WhereClause([['girisSaat','<',$end],
                                   ['cikisSaat','>',$start],
                                   ['rezervasyonTarih','=',$date]]);
    }

    public function _TotalRecord($start,$end,$date)
    {
        return Rezervation::where([['rezervations.girisSaat','<=',$start],
                                   ['rezervations.cikisSaat','>=',$end],
                                   ['rezervations.rezervasyonTarih','=',$date]
                                  ])
                            ->count('rezervations.id');
    }

    public function _Search($start,$end,$date,$offset,$limit)
    {
        return Rezervation::join('salon','rezervations.salon_id','=','salons.id')
                          ->join('customers','rezervations.customer_id','=','customers.id')
                          ->select('rezervations.id AS id',
                                   'rezervations.kiraTutari AS kiraTutari',
                                   'rezervations.menuTutari AS menuTutari',
                                   'rezervations.girisSaat AS girisSaat',
                                   'rezervations.cikisSaat AS cikisSaat',
                                   'rezervations.rezervasyonTarih AS rezervasyonTarih',
                                   'rezervations.odemeDurum AS odemeDurum',
                                   'customers.adi AS ad',
                                   'customers.soyAdi AS soyAdi',
                                   'customers.telefon AS telefon',
                                   'salon.salonAdi AS salonAdi')
                          ->where([['rezervations.girisSaat','<=',$start],
                                   ['rezervations.cikisSaat','>=',$end],
                                   ['rezervations.rezervasyonTarih','=',$date]
                                  ])
                          ->orderBy('rezervations.id','DESC')
                          ->offset($offset)
                          ->limit($limit)
                          ->get();
    }

    public function _GetAllByLimit(int $offset,int $limit)
    {
        return Rezervation::join('salon','rezervations.salon_id','=','salon.id')
                          ->join('customers','rezervations.customer_id','=','customers.id')
                          ->select('rezervations.id AS id',
                                   'rezervations.kiraTutari AS kiraTutari',
                                   'rezervations.menuTutari AS menuTutari',
                                   'rezervations.girisSaat AS girisSaat',
                                   'rezervations.cikisSaat AS cikisSaat',
                                   'rezervations.rezervasyonTarih AS rezervasyonTarih',
                                   'rezervations.odemeDurum AS odemeDurum',
                                   'customers.adi AS adi',
                                   'customers.soyAdi AS soyAdi',
                                   'customers.telefon AS telefon',
                                   'salon.salonAdi AS salonAdi')
                          ->orderBy('rezervations.id','DESC')
                          ->offset($offset)
                          ->limit($limit)
                          ->get();
    }

    public function GetMenuByRezervationId(int $rezervationID)
    {
//        SELECT M.id AS id,
//	   M.menuAdi AS menuAdi,
//       M.tutar AS tutar
//       FROM rezervation_menus AS RM
//       INNER JOIN menus AS M ON RM.menu_id=M.id
//       WHERE RM.rezervasyon_id='".$rezervationID."';

        return Rezervation::where('id',$rezervationID)->first()->menus()->get();
    }

    public function GetAllByMonthNow() // Mevcut Aya ve Yıla Ait Rezervasyonları Getirir
    {
        return Rezervation::whereMonth('rezervasyonTarih','=',date('m'))
                          ->whereYear('rezervasyonTarih','=',date('Y'))
                          ->get();
    }

    public function GetByMonthAndYear($month,$year) // seçilen yıl ve aya göre ajanda takvimini getir
    {
        return Rezervation::whereMonth('rezervasyonTarih','=',$month)
                          ->whereYear('rezervasyonTarih','=',$year)
                          ->get();
    }

    public function GetBySalonId(int $salonId) // SalonId Yardımıyla Rezervasyonu Getirir
    {
        return Rezervation::where('salon_id',$salonId)->first();
    }

}
