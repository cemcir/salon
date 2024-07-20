<?php

namespace App\Http\Controllers\Api\Backend;

use App\Business\Abstract\IExpenseService;
use App\Business\Validation\Keys;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ExpenseController extends Controller
{
    private IExpenseService $expenseService;

    public function __construct(IExpenseService $expenseService)
    {
        $this->expenseService=$expenseService;
        parent::__construct($expenseService,[]);
    }

    public function ExpenseAdd(Request $request)
    {
        $expense=$request->only(Keys::Expense());
        $safe=$request->only(Keys::Safe());

        $result=$this->expenseService->ExpenseAdd($expense,$safe);
        if($result->Status()) {
            return response()->json(['status'=>200,'msg'=>$result->Message()],200);
        }

        return response()->json(['status'=>400,'msg'=>$result->Message()],400);
    }

}
