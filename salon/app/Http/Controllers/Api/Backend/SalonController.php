<?php

namespace App\Http\Controllers\Api\Backend;

use App\Business\Abstract\ISalonService;
use App\Business\Validation\ValidationRules;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SalonController extends Controller
{
    private ISalonService $salonService;

    public function __construct(ISalonService $salonService)
    {
        $this->salonService=$salonService;
        parent::__construct($salonService,ValidationRules::SalonValidator());
    }

    public function SalonDelete(Request $request)
    {

    }

    // rezervasyon sayısı 3 ten büyük carilerin sql sorgusu için deneme yapıldı

//    public function SalonAdd(Request $request)
//    {
//        return Rezervation::select('carikart_id',
//               DB::raw('count(carikart_id) as total'))
//               ->groupBy('carikart_id')
//               ->having('total','>',3)
//               ->get();
//    }

}
