<?php
namespace App\DataAccess\Concrete\Eloquent;

use App\Core\DataAccess\Eloquent\EloquentRepositoryBase;
use App\DataAccess\Abstract\IMenuDal;
use App\Models\Menu;

class ElMenuDal extends EloquentRepositoryBase implements IMenuDal
{
    public function __construct(Menu $menu)
    {
        parent::__construct($menu);
    }

    public function TotalMenuPrice(array $menuId)
    {
        return Menu::whereIn('id',$menuId)->sum('tutar');
    }

    public function GetAllByCategoryId(int $categoryId) // kategoriye ait menüleri getir
    {
        return Menu::where('kategori_id',$categoryId)->get();
    }

}
