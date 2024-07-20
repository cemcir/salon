<?php

namespace App\Business\Concrete;
use App\Business\Abstract\IExpenseService;
use App\Business\Abstract\IShiftService;
use App\Business\Constants\Abstract\IMessage;
use App\Core\Utilities\Results\ErrorResult;
use App\Core\Utilities\Results\IResult;
use App\Core\Utilities\Results\SuccessResult;
use App\DataAccess\Abstract\IExpenseDal;
use App\DataAccess\Abstract\ISafeDal;
use App\DataAccess\Abstract\IShiftDal;
use Illuminate\Support\Facades\DB;

class ExpenseManager extends ServiceManager implements IExpenseService
{
    private ISafeDal $safeDal;
    private IMessage $message;
    private IExpenseDal $expenseDal;
    private IShiftService $shiftService;
    public function __construct(IShiftService $shiftService,IMessage $message,IExpenseDal $expenseDal,ISafeDal $safeDal,IShiftDal $shiftDal)
    {
        $this->safeDal=$safeDal;
        $this->message=$message;
        $this->expenseDal=$expenseDal;
        $this->shiftService=$shiftService;
        parent::__construct1($expenseDal,$shiftDal,[]);
    }

    // tahsilat turu 4 hareket 2 ise borç girişi
    // tahsilat turu 1,2 veya 3 hareket 2 ise ödeme
    public function ExpenseAdd(array $expense,array $safe):IResult // gider ekler
    {
        try {
            DB::beginTransaction();
            $expenseId=$this->expenseDal->LastInsertID($expense); // gider tablosuna ekle
            $safe['expense_id']=$expenseId;
            $safe['vardiya_id']=$this->shiftId; // vardiya id si
            $safe['islemTuru']=2;
            $this->safeDal->Add($safe); // kasaya ekle
            $this->shiftService->Calculator($this->shiftId); // vardiya güncelle

            DB::commit();
            return new SuccessResult($this->message->ExpenseAdded());
        }
        catch (\Exception $ex) {
            DB::rollBack();
            return new ErrorResult($ex->getMessage());
        }
    }


}
