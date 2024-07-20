<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class SalonType extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table='salon_types';
    protected $fillable=['turAdi'];

    protected $casts=[
        'created_at'=>'datetime:Y-m-d H:i:s',
        'updated_at'=>'datetime:Y-m-d H:i:s'
    ];

    public function salons():HasMany
    {
        return $this->hasMany(Salon::class,'tur_id');
    }
}
