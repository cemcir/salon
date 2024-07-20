<?php

namespace App\DataAccess\Concrete\Eloquent;

use App\Core\DataAccess\Eloquent\EloquentRepositoryBase;
use App\DataAccess\Abstract\IExpenseDal;
use App\Models\Expense;
use Illuminate\Database\Eloquent\Collection;

class ElExpenseDal extends EloquentRepositoryBase implements IExpenseDal
{
    public function __construct(Expense $expense)
    {
        parent::__construct($expense);
    }

    //methodun başında _ işareti varsa miras yoluyla gelmeyen method demektir
    public function _GetAllByLimit($start, $end): Collection
    {
        return Expense::join('categories','expenses.kategori_id','=','categories.id')
                      ->select('expenses.tutar as tutar',
                               'categories.kategoriAdi as kategoriAdi')
                      ->orderBy('expenses.id','DESC')
                      ->offset($start)
                      ->limit($end)
                      ->get();
    }

    public function DeleteByPaymentId(int $paymentId)
    {
        return Expense::where('cari_tahsilat_id',$paymentId)->delete();
    }

}
