<?php

namespace App\Business\Abstract;
use App\Core\Utilities\Results\IResult;
use App\Core\Utilities\Results\IDataResult;

interface IService
{
    public function GetAll():IDataResult;
    public function Add(array $arr,array $logics=null):IResult;
    public function LastInsertID(array $arr):IDataResult;
    public function Update(array $arr,int $id,array $logics=null):IResult;
    public function Delete(int $id):IResult;
    public function Get(int $id):IDataResult;
    public function GetAllByLimit($start,$end,$sort):IDataResult;
}
