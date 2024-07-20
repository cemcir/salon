<?php

namespace App\Http\Controllers\Api\Backend;

use App\Business\Abstract\IShiftService;
use App\Http\Controllers\Controller;

class ShiftController extends Controller // vardiya controller
{
    private IShiftService $shiftService;

    public function __construct(IShiftService $shiftService)
    {
        $this->shiftService=$shiftService;
        parent::__construct($shiftService,[],[]);
    }

    public function Close() // vardiya kapat
    {
        $result=$this->shiftService->Close();
        if($result->Status()) {
            return response()->json(['status'=>200,'msg'=>$result->Message()]);
        }
        return response()->json(['status'=>400,'msg'=>$result->Message()],400);
    }

    public function Summar() // vardiya özeti
    {
        $result=$this->shiftService->Summar();
        if($result->Status()) {
            return response()->json(['status'=>200,'data'=>$result->Data(),'msg'=>$result->Message()],200);
        }
        return response()->json(['status'=>404,'data'=>[],'msg'=>$result->Message()]);
    }

}
