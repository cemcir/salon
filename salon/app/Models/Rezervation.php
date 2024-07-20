<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Rezervation extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table='rezervations';
    protected $fillable=['kiraTutari','menuTutari','girisSaat','cikisSaat','merasim','rezervasyonTarih','rezervasyonNotu','odemeDurum','davetli','carikart_id','user_id'];

    protected $casts=[
        'created_at'=>'datetime:Y-m-d H:i:s',
        'updated_at'=>'datetime:Y-m-d H:i:s'
    ];

    public function customer():BelongsTo // bir rezervasyonun bir carisi var
    {
        return $this->belongsTo(Customer::class,'carikart_id');
    }

    public function menus():BelongsToMany // bir rezervasyonun birden çok menüsü var
    {
        return $this->belongsToMany(Menu::class,'rezervation_menus','rezervasyon_id','menu_id');
    }

    public function payments():HasMany // bir rezervasyona ait birden çok tahsilat var
    {
        return $this->hasMany(Payment::class,'rezervasyon_id');
    }

}
