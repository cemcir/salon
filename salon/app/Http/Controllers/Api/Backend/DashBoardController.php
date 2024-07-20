<?php

namespace App\Http\Controllers\Api\Backend;

use App\Business\Abstract\IRezervationService;
use App\Business\Abstract\IShiftService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

//panele giriş yapıldığı andaki ana ekran backend
class DashBoardController extends Controller
{
    private IShiftService $shiftService;
    private IRezervationService $rezervationService;
    public function __construct(IRezervationService $rezervationService,IShiftService $shiftService)
    {
        $this->shiftService=$shiftService;
        $this->rezervationService=$rezervationService;
        parent::__construct($rezervationService,[],[]);
    }

    public function GetByMonthNow() // Mevcut Aya Ait Rezervasyonları Getirir
    {
        $result=$this->shiftService->Start();
        if(!$result->Status()) {
            return response()->json(['status'=>400,'msg'=>$result->Message()],400);
        }

        $result=$this->rezervationService->GetByMonthNow();
        if($result->Status()) {
            return response()->json(['status'=>200,'data'=>$result->Data()],200);
        }
        return response()->json(['status'=>404,'data'=>[]],404);
    }

    public function GetByMonthAndYear($month,$year) // Gönderilen Ay ve Yıla Ait Rezervasyonları Listeler
    {
        $result=$this->rezervationService->GetByMonthAndYear($month,$year);
        if($result->Status()) {
            return response()->json(['status'=>200,'data'=>$result->Data()]);
        }
        return response()->json(['status'=>404,'data'=>[]],404);
    }

}
