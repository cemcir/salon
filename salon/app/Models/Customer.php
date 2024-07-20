<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table='customers';
    protected $fillable=['adi','soyadi','gsm','telefon','adres','eposta','tcNo','bakiye'];

    protected $casts=[
        'created_at'=>'datetime:Y-m-d H:i:s',
        'updated_at'=>'datetime:Y-m-d H:i:s'
    ];

    public function rezervations():HasMany
    {
        return $this->hasMany(Rezervation::class,'carikart_id');
    }

    public function paymentcustomers():HasMany
    {
//        DB::table('rezervations')
//            ->select('carikart_id',DB::raw('count(id) as total'))
//            ->groupBy('carikart_id')
//            ->having('total','>',3)
//            ->get();

        return $this->hasMany(PaymentCustomer::class,'carikart_id');
    }

    //bana kalanı bul desem ?

    //toplamTutar=round(kiraTutarı+menuTutarı,2);
    //toplamTahsilat=round(toplamTahsilat,2);
    //kalan=round(toplamTutar-toplamTahsilat,2);
}
