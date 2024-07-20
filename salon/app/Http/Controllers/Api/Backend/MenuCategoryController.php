<?php

namespace App\Http\Controllers\Api\Backend;

use App\Business\Abstract\IMenuCategoryService;
use App\Business\Abstract\IService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Queue\ManuallyFailedException;

class MenuCategoryController extends Controller
{
    private IMenuCategoryService $menuCategoryService;

    public function __construct(IMenuCategoryService $menuCategoryService)
    {
        $this->menuCategoryService=$menuCategoryService;
        parent::__construct($menuCategoryService,[],[]);
    }

}
