<?php

namespace App\Core\DataAccess\Eloquent;

use App\Core\DataAccess\IEloquentRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class EloquentRepositoryBase implements IEloquentRepository
{
    protected $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function GetAll(): Collection
    {
        return $this->model::all();
    }

    public function Add(array $arr): Model
    {
        return $this->model::create($arr);
    }

    public function Update(array $arr,int $id): int
    {
        return $this->model::where('id','=',$id)->update($arr);
    }

    public function Delete(int $id): int
    {
        return $this->model::where('id',$id)->delete();
    }

    public function Get(int $id): ?Model
    {
        return $this->model::where('id', $id)->first();
    }

    public function WhereClause(array $conditions): ?Model
    {
//        $conditions=[
//            ['salonTurID','=',1],
//            ['turAdi','=','deneme']
//        ];

        //return $this->model::where($conditions[0][0],$conditions[0][2])->orWhere($conditions[1][0],$conditions[1][2])->first();

        return $this->model::where($conditions)->first();
    }

    public function LastInsertID(array $arr): int
    {
        return $this->model::create($arr)->id;
    }

    public function GetAllByLimit(int $offset, int $limit, string $sort): Collection
    {
        return $this->model::orderBy('id',$sort)
                             ->offset($offset)
                             ->limit($limit)
                             ->get();
    }

    public function Search(array $conditions,$offset,$limit)
    {
        return $this->model::where($conditions)
                           ->offset($offset)
                           ->limit($limit)
                           ->get();
    }

    public function TotalRecord(array $conditions): int
    {
        return $this->model::where($conditions)->count();
    }

    public function WhereIn(string $column,array $conditions)
    {
        return $this->model::whereIn($column,$conditions)->get();
    }

    public function TotalPrice(string $column,array $conditions)
    {
        return $this->model::where($conditions)->sum($column);
    }

    public function TotalCount():int
    {
        return $this->model::count();
    }

}
