<?php

namespace App\Http\Controllers\Api\Backend;

use App\Business\Abstract\IPaymentService;
use App\Business\Validation\Keys;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PaymentController extends Controller  // tahsilat controller
{
    private IPaymentService $paymentService;
    public function __construct(IPaymentService $paymentService)
    {
        parent::__construct($paymentService,[],[]);
        $this->paymentService=$paymentService;
    }

    public function PaymentAdd(Request $request):array
    {
        $payment=$request->only(Keys::Payment()); // tahsilat
        $income=$request->only(Keys::Income()); // gelir
        $safe=$request->only(Keys::Safe()); // kasa
        $customer=$request->only(Keys::CustomerDebt()); // cari borcu

        $result=$this->paymentService->PaymentAdd($payment,$income,$safe,$customer);
        if($result->Status()) {
            return ['status'=>200,'msg'=>$result->Message(),'data'=>$result->Data()];
        }

        return ['status'=>400,'msg'=>$result->Message(),'data'=>[]];
    }

    public function PaymentDelete(Request $request)
    {
        $data=json_decode($request->getContent(),true);

        $result=$this->paymentService->PaymentDelete($data['tahsilatID']);
        if($result->Status()) {
            return ['status'=>200,'msg'=>$result->Message(),'data'=>$result->Data()];
        }
        return ['status'=>400,'msg'=>$result->Message(),'data'=>$result->Data()];
    }

}
