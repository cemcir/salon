<?php

namespace App\Http\Controllers\Api\Backend;

use App\Business\Abstract\ICustomerService;
use App\Business\Abstract\IShiftService;
use App\Http\Controllers\Controller;

class CustomerController extends Controller // cari controller
{
    private ICustomerService $customerService;
    public function __construct(ICustomerService $customerService)
    {
        $this->customerService=$customerService;
        parent::__construct($customerService,[],[]);
    }

    public function Search(string $search,int $start,int $limit)
    {
        $result=$this->customerService->Search($search,$start,$limit);
        if($result->Status()) {
            return response()->json(['status'=>200,'data'=>$result->Data()['customer'],'toplamKayit'=>$result->Data()['count']],200);
        }
        return response()->json(['status'=>404,'data'=>[],'toplamKayit'=>0],404);
    }

    public function GetAllByLimit($start,$limit)
    {
        $result=$this->customerService->GetAllByLimit($start,$limit,'DESC');
        if($result->Status()) {
            return response()->json(['status'=>200,'data'=>$result->Data()['data'],'toplamKayit'=>$result->Data()['count']]);
        }
        return response()->json(['status'=>404,'data'=>[]]);
    }

}
