<?php

namespace App\Core\DataAccess;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface IEloquentRepository
{
    public function Add(array $arr):Model;
    public function LastInsertID(array $arr):int;
    public function GetAll():Collection;
    public function Update(array $arr,int $id):int;
    public function Delete(int $id):int;
    public function Get(int $id): ?Model;
    public function WhereClause(array $conditions): ?Model ;
    public function GetAllByLimit(int $offset,int $limit,string $sort):Collection;
    public function Search(array $conditions,int $offset,int $limit);
    public function TotalRecord(array $conditions):int;
    public function WhereIn(string $column,array $conditions);
    public function TotalPrice(string $column,array $conditions);
    public function TotalCount():int;
}
