<?php

namespace App\Http\Controllers\Api\Backend;

use App\Business\Abstract\IRezervationMenuService;
use App\Business\Validation\Keys;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RezervationMenuController extends Controller
{
    private IRezervationMenuService $rezervationMenuService;

    public function __construct(IRezervationMenuService $rezervationMenuService)
    {
        parent::__construct($rezervationMenuService,[],[]);
        $this->rezervationMenuService=$rezervationMenuService;
    }

    // rezervasyon ekleme işlemi
    public function RezervationMenuAdd(Request $request)
    {
        $menu=[];
        if($request->has('menu')) {
            $menu=$request->post('menu');
        }
        $rezervation=$request->only(Keys::Rezervation());

        $result=$this->rezervationMenuService->RezervationMenuAdd($rezervation,$menu);

        if($result->Status()) {
            return response()->json(['status'=>200,'msg'=>$result->Message()],200);
        }
        return response()->json(['status'=>400,'msg'=>$result->Message()],400);
    }

    public function RezervationMenuUpdate(Request $request):array
    {
        $menu=[];
        if($request->has('menu')) {
            $menu=$request->post('menu');
        }
        $result=$this->rezervationMenuService->RezervationMenuUpdate($menu,$request->rezervasyonId);

        if($result->Status()) {
            return ['status'=>200,'data'=>$result->Data(),'msg'=>$result->Message()];
        }

        return ['status'=>400,'data'=>[],'msg'=>$result->Message()];
    }

    public function RezervationMenuDelete(Request $request):array
    {
        $data=json_decode($request->getContent(),true);
        $result = $this->rezervationMenuService->RezervationMenuDelete($data['id']);

        if ($result->Status()) {
            return ['status' => 200,'msg' => $result->Message(),'data' => $result->Data()];
        }
        return ['status'=>400,'msg'=>$result->Message(),'data'=>$result->Data()];
    }

}
