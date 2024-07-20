<?php

namespace App\Http\Controllers\Api\Backend;

use App\Business\Abstract\IMenuService;
use App\Http\Controllers\Controller;

class MenuController extends Controller
{
    private IMenuService $menuService;

    public function __construct(IMenuService $menuService)
    {
        $this->menuService=$menuService;
        parent::__construct($menuService,[],[]);
    }

    public function GetAllByCategoryId(int $categoryId) // kategoriye ait menüleri getir
    {
        $result=$this->menuService->GetAllByCategoryId($categoryId);
        if($result->Status()) {
            return response()->json(['status'=>200,'data'=>$result->Data()],200);
        }
        return response()->json(['status'=>404,'data'=>[]],404);
    }

}
