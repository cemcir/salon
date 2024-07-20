<?php

namespace App\Http\Controllers\Api\Backend;

use App\Business\Abstract\IncomeService;
use App\Business\Validation\ValidationRules;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class IncomeControlller extends Controller // gelir controller
{
    private IncomeService $incomeService;

    public function __construct(IncomeService $incomeService)
    {
        $this->incomeService=$incomeService;
        parent::__construct($incomeService,ValidationRules::IncomeValidator());
    }

    public function GetAllByLimit(Request $request)
    {
        $data=$request->post();
        $result=$this->incomeService->GetAllByLimit($data['baslangic'],$data['limit'],'DESC');

        if($result->Status()) {
            return response()->json(['status'=>200,'data'=>$result->Data()],200);
        }
        return response()->json(['status'=>404,'data'=>[]],404);
    }

}
