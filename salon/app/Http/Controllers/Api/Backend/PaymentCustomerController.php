<?php

namespace App\Http\Controllers\Api\Backend;

use App\Business\Abstract\IPaymentCustomerService;
use App\Business\Validation\Keys;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PaymentCustomerController extends Controller // cari tahsilat controller
{
    private IPaymentCustomerService $paymentCustomerService;

    public function __construct(IPaymentCustomerService $paymentCustomerService)
    {
        $this->paymentCustomerService=$paymentCustomerService;
        parent::__construct($paymentCustomerService,[],[]);
    }

    public function GetExtre(int $cariId,int $start,int $limit)
    {
        $result = $this->paymentCustomerService->GetExtre($cariId, $start, $limit);
        if ($result->Status()) {
            return response()->json(['status'=>200,'data'=>$result->Data()['payment'],'toplamKayit'=>$result->Data()['count'],'bakiye'=>$result->Data()['balance']],200);
        }
        return response()->json(['status'=>404,'data'=>[],'toplamKayit'=>0,'bakiye'=>0], 404);
    }

    public function CustomerPayment(Request $request)
    {
        $payment = $request->only(Keys::CustomerPayment()); // cari tahsilat
        $income = $request->only(Keys::Income()); // gelir
        $safe = $request->only(Keys::Safe()); // kasa

        $result = $this->paymentCustomerService->CustomerPayment($payment,$income,$safe);
        if ($result->Status()) {
            return response()->json(['status'=>200,'msg'=> $result->Message()]);
        }
        return response()->json(['status'=>400,'msg'=> $result->Message()]);
    }

    public function TransferRecord(Request $request) // Cari Devir Kaydı
    {
        $transfer=$request->only(Keys::TransferRecord());
        $result=$this->paymentCustomerService->TransferRecord($transfer);
        if($result->Status()) {
            return response()->json(['status'=>200,'msg'=>$result->Message()],200);
        }

        return response()->json(['status'=>400,'msg'=>$result->Message()],400);
    }

    public function CustomerDebt(Request $request)
    {
        $expense=$request->only(Keys::Expense());
        $payment=$request->only(Keys::CustomerDebt());
        $safe=$request->only(Keys::Safe());

        $result=$this->paymentCustomerService->CustomerDebt($payment,$safe,$expense);
        if($result->Status()) {
            return response()->json(['status'=>200,'msg'=>$result->Message()]);
        }
        return response()->json(['status'=>400,'msg'=>$result->Message()]);
    }

    public function CustomerPaymentDelete(Request $request)
    {
        $result=$this->paymentCustomerService->CustomerPaymentDelete($request->tahsilatId);
        if($result->Status()) {
            return response()->json(['status'=>200,'msg'=>$result->Message()],200);
        }
        return response()->json(['status'=>400,'msg'=>$result->Message()],400);
    }

    //Aynı Api nin C# Kodu Reisten Usta Kodlar PHP Consultant Cemcir

    //public IActionResult CustomerPayment(PaymentDto paymentCustomer) {
    //Payment payment=(Payment)paymenCustomer;
    //Safe safe=(Safe)paymentCustomer;
    //Income income=(Income)paymentCustomer;

    //var result=this.paymentCustomerService.CustomerPayment(payment,safe,income);

    //if(result.Status) {
         //return Ok(result);
    //}
    //  return BadRequest(result);
    //}

}
