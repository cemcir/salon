<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Payment extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table='payments';

    protected $fillable=['tutar','tahsilatTuru','rezervasyon_id','vardiya_id','user_id'];

    protected $casts=[
        'created_at'=>'datetime:Y-m-d H:i:s',
        'updated_at'=>'datetime:Y-m-d H:i:s'
    ];

    public function rezervation():BelongsTo
    {
        return $this->belongsTo(Rezervation::class,'rezervasyon_id');
    }

}
