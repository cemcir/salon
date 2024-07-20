<?php

namespace App\Business\Concrete;

use App\Business\Abstract\IMenuCategoryService;
use App\Core\DataAccess\IEloquentRepository;
use App\DataAccess\Abstract\IMenuCategoryDal;

class MenuCategoryManager extends ServiceManager implements IMenuCategoryService
{
    private IMenuCategoryDal $menuCategoryDal;

    public function __construct(IMenuCategoryDal $menuCategoryDal)
    {
        $this->menuCategoryDal=$menuCategoryDal;
        parent::__construct($menuCategoryDal,[]);
    }


}
