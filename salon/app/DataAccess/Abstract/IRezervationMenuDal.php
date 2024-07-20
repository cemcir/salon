<?php

namespace App\DataAccess\Abstract;

use App\Core\DataAccess\IEloquentRepository;
use Illuminate\Database\Eloquent\Model;

interface IRezervationMenuDal extends IEloquentRepository
{
    public function RezervationMenuExist(int $menuID,int $rezervationID):?Model; // Menüye Ait Rezervayon Kaydı Olup Olmadığını Kontrol Eder
    public function TotalMenuPrice(int $rezervationID); // Rezervasyona Ait Toplam Menu Tutarını Hesaplar
    public function DeleteByRezervationId(int $rezervationId);
    public function GetByRezervationId(int $rezervationId); // Rezervasyon İle Getir
}
