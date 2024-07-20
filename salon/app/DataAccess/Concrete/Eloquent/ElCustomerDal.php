<?php

namespace App\DataAccess\Concrete\Eloquent;

use App\Core\DataAccess\Eloquent\EloquentRepositoryBase;
use App\DataAccess\Abstract\ICustomerDal;
use App\Models\Customer;

class ElCustomerDal extends EloquentRepositoryBase implements ICustomerDal
{
    public function __construct(Customer $customer)
    {
        parent::__construct($customer);
    }

    public function CustomerSearch(string $search,int $start,int $limit)
    {
        return Customer::where('adi','like','%'.$search.'%')
                       ->orWhere('soyAdi','like','%'.$search.'%')
                       ->orWhere('gsm','like','%'.$search.'%')
                       ->orWhere('telefon','like','%'.$search.'%')
                       ->orWhere('adres','like','%'.$search.'%')
                       ->orWhere('eposta','like','%'.$search.'%')
                       ->orWhere('tcNo','like','%'.$search.'%')
                       ->orWhere('bakiye','like','%'.$search.'%')
                       ->orderBy('id','DESC')
                       ->offset($start)
                       ->limit($limit)
                       ->get();
    }

    // aynı modelin C# Asp.net Core entity framework ile yazılmış hali
    //string search=string.Concat('%',search,'%')
    //var result=this.context.Customer.Where(c=>EF.Functions.Like(c.adi,search)
    //                                .Select(c=>new {
                                          //Ad=c.adi,
    //                                 }).ToList(); //SingleOrDefault();
    public function CustomerSearchCount(string $search)
    {
        return Customer::where('adi','like','%'.$search.'%')
                       ->orWhere('soyAdi','like','%'.$search.'%')
                       ->orWhere('gsm','like','%'.$search.'%')
                       ->orWhere('telefon','like','%'.$search.'%')
                       ->orWhere('adres','like','%'.$search.'%')
                       ->orWhere('eposta','like','%'.$search.'%')
                       ->orWhere('tcNo','like','%'.$search.'%')
                       ->orWhere('bakiye','like','%'.$search.'%')
                       ->count('id');
    }

}
