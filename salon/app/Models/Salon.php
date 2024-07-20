<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Salon extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table='salons';
    protected $fillable=['salonAdi'];

    protected $casts=[
        'created_at'=>'datetime:Y-m-d H:i:s',
        'updated_at'=>'datetime:Y-m-d H:i:s'
    ];

    public function salontype():BelongsTo
    {
        return $this->belongsTo(SalonType::class,'tur_id');
    }
}
