<?php

namespace App\DataAccess\Abstract;

use App\Core\DataAccess\IEloquentRepository;

interface IRezervationDal extends IEloquentRepository
{
    public function _Control($start,$end,$date);
    public function _TotalRecord($start,$end,$date);
    public function _Search($startTime,$exitTime,$date,$offset,$limit);
    public function _GetAllByLimit(int $offset, int $limit);
    public function GetMenuByRezervationId(int $rezervationID); // Rezervasyona Ait Menüleri Getir;
    public function GetAllByMonthNow();
    public function GetByMonthAndYear($month,$year);
    public function GetBySalonId(int $salonId);
}
