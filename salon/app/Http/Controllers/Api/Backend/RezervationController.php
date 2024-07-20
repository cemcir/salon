<?php

namespace App\Http\Controllers\Api\Backend;

use App\Business\Abstract\IRezervationService;
use App\Business\Validation\Keys;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RezervationController extends Controller // rezervasyon controller
{
    private IRezervationService $rezervationService;

    public function __construct(IRezervationService $rezervationService)
    {
        $this->rezervationService=$rezervationService;
        parent::__construct($rezervationService,[],[]);
    }

    //urunlere gore arayacak
    //kategoriye gore coklu arayacak
    //markaya gore coklu arayacak
    // urun tablosu

    // urunId ,urunAdi ,kdv,fiyat ,resim , kategori_id , marka_id

    //***************************************************************

    //kira tutari, girissaat, cikissaat,rezervasyon notu, davetli sayısı gibi
    public function RezervationUpdate(Request $request) // rezervasyonu günceller
    {
        $rezervation=$request->only(Keys::Rezervation());

        $result=$this->rezervationService->RezervationUpdate($rezervation);
        if($result->Status()) {
            return response()->json(['status'=>200,'msg'=>$result->Message()],200);
        }
        return response()->json(['status'=>400,'msg'=>$result->Message()],400);
    }

    // limit ve offset yardımıyla rezervasyon listesini getirmek için kullanılır
    public function GetAllByLimit($start,$end) {

        $result=$this->rezervationService->GetAllByLimit($start,$end,'DESC');
        if($result->Status()) {
            return response()->json(['status'=>200,'data'=>$result->Data()['data'],'toplamKayit'=>$result->Data()['count']]);
        }
        return response()->json(['status'=>404,'data'=>[],'toplamKayit'=>0],404);
    }

    public function Search(Request $request) {

        $data=$request->only(Keys::RezervationSearch());

        $result=$this->rezervationService->Search($data['girisSaat'],$data['cikisSaat'],$data['tarih'],$data['baslangic'],$data['limit']);
        if($result->Status()) {
            return ['status'=>200,'data'=>$result->Data()['rezervation'],'toplamKayit'=>$result->Data()['totalRecord']];
        }
        return ['status'=>400,'data'=>[]];
    }

    public function GetRezervation(int $rezervationID)
    {
        $result=$this->rezervationService->GetRezervation($rezervationID);

        if($result->Status()) {
            $data=$result->Data()['rezervation'];
            $data['menu']=$result->Data()['menu'];
            $data['kategori']=$result->Data()['kategori'];

            return response()->json(['status'=>200,'data'=>$data],200);
        }
        return response()->json(['status'=>404,'data'=>[]],404);
    }

}
