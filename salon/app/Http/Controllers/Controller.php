<?php

namespace App\Http\Controllers;

use App\Business\Abstract\IService;
use App\Business\Abstract\IShiftService;
use App\Core\Validation\Validate;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    private array $keys;
    protected int $shiftId=0;
    private IService $service;
    private array $validationRules;
    private IShiftService $shiftService;

    public function __construct(IService $service,array $validationRules=null,array $keys=null)
    {
        $this->keys=$keys;
        $this->service=$service;
        $this->validationRules=$validationRules;
    }

    //burada logics dizisi iş kurallarını yazmak için kullanılır
    public function Add(Request $request,array $logics=null) {

        if(!empty($this->validationRules)) {
            $result=Validate::ValidationMake($request,$this->validationRules);

            if($result!=null) {
                return response()->json(['status'=>400,'msg'=>$result->Message()],400);
            }
        }

        $data=$request->only($this->keys);
        $result=$this->service->Add($data,$logics);

        if($result->Status()) {
            return response()->json(['status'=>200,'msg'=>$result->Message()],200);
        }
        return response()->json(['status'=>400,'msg'=>$result->Message()],400);
    }

    public function Get(int $id) {

        $result=$this->service->Get($id);
        if($result->Status()) {
            return response()->json(['status'=>200,'data'=>$result->Data()],200);
        }
        return response()->json(['status'=>404,'data'=>[]],404);
    }

    public function Update(Request $request) {

        if(!empty($this->validationRules)) {
            $result=Validate::ValidationMake($request,$this->validationRules);

            if($result!=null) {
                return response()->json(['status'=>400,'msg'=>$result->Message()],400);
            }
        }

        $data=$request->only($this->keys);

        $result=$this->service->Update($data,$data['id']);
        if($result->Status()) {
            return response()->json(['status'=>200,'msg'=>$result->Message()],200);
        }
        return response()->json(['status'=>400,'msg'=>$result->Message()],400);
    }

    public function Delete(Request $request) {

        $result=$this->service->Delete($request->id);
        if($result->Status()) {
            return response()->json(['status'=>200,'msg'=>$result->Message()],200);
        }
        return response()->json(['status'=>400,'msg'=>$result->Message()],400);
    }

    public function GetAll() {

        $result=$this->service->GetAll();
        if($result->Status()) {
            return response()->json(['status'=>200,'data'=>$result->Data()],200);
        }
        return response()->json(['status'=>404,'data'=>$result->Data()],404);
    }

}
