<?php

namespace App\Http\Controllers\Api\Backend;

use App\Business\Abstract\ISalonTypeService;
use App\Http\Controllers\Controller;
class SalonTypeController extends Controller
{
    private ISalonTypeService $salonTypeService;

    public function __construct(ISalonTypeService $salonTypeService)
    {
        parent::__construct($salonTypeService);
        $this->salonTypeService=$salonTypeService;
    }

}
