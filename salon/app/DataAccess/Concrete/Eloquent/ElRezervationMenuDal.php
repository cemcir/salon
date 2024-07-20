<?php

namespace App\DataAccess\Concrete\Eloquent;
use App\Core\DataAccess\Eloquent\EloquentRepositoryBase;
use App\DataAccess\Abstract\IRezervationMenuDal;
use App\Models\RezervationMenu;
use Illuminate\Database\Eloquent\Model;

class ElRezervationMenuDal extends EloquentRepositoryBase implements IRezervationMenuDal
{
    public function __construct(RezervationMenu $rezervationMenu)
    {
        parent::__construct($rezervationMenu);
    }

    public function RezervationMenuExist(int $menuID, int $rezervationID):? Model
    {
        return $this->WhereClause([['opsiyonID','=',$menuID],['rezervasyonID','=',$rezervationID]]);
    }

    public function TotalMenuPrice(int $rezervationID)
    {
        return $this->TotalPrice('tutar',[['rezervasyonID','=',$rezervationID]]);
    }

    public function DeleteByRezervationId(int $rezervationId)
    {
        return RezervationMenu::where('rezervasyon_id',$rezervationId)->delete();
    }

    public function GetByRezervationId(int $rezervationId)
    {
        return RezervationMenu::where('rezervasyon_id',$rezervationId)->first();
    }

}
