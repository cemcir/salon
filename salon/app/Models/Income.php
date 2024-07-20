<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Income extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table='incomes';
    protected $fillable=['tutar','vardiya_id','tahsilatTuru','cari_tahsilat_id','tahsilat_id'];

    protected $casts=[
        'created_at'=>'datetime:Y-m-d H:i:s',
        'updated_at'=>'datetime:Y-m-d H:i:s'
    ];

    public function shift():BelongsTo
    {
        return $this->belongsTo(Shift::class,'vardiya_id');
    }

}
