<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Shift extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table='shifts';
    protected $fillable=['baslangicTarih','bitisTarih','tahsilat','cariTahsilat','gelir','gider','netKasa','krediKarti','havale'];

    protected $casts=[
        'created_at'=>'datetime:Y-m-d H:i:s',
        'updated_at'=>'datetime:Y-m-d H:i:s'
    ];

}
