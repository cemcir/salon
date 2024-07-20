<?php

namespace App\DataAccess\Concrete\Eloquent;

use App\Core\DataAccess\Eloquent\EloquentRepositoryBase;
use App\DataAccess\Abstract\IMenuCategoryDal;
use App\Models\MenuCategory;

class ElMenuCategoryDal extends EloquentRepositoryBase implements IMenuCategoryDal
{
    public function __construct(MenuCategory $menuCategory)
    {
        parent::__construct($menuCategory);
    }


}
