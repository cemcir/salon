<?php

namespace App\Business\Abstract;

use App\Core\Utilities\Results\IDataResult;
use App\Core\Utilities\Results\IResult;

interface IRezervationService extends IService
{
    public function RezervationUpdate(array $rezervation):IDataResult;
    public function RezervationGetAllByLimit($start,$end): IDataResult;
    public function Search($start,$end,$date,$offset,$limit):IDataResult;
    public function TotalRecord($start,$end,$date):IDataResult;
    public function GetRezervation(int $rezervationID):IDataResult;
    public function RezervationDelete(int $rezervationId):IResult;
    public function GetByMonthNow():IDataResult;
    public function GetByMonthAndYear($month,$year):IDataResult;
}
