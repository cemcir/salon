<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Expense extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table='expenses';
    protected $fillable=['tutar','tahsilatTuru','kategori_id','cari_tahsilat_id','vardiya_id'];

    protected $casts=[
        'created_at'=>'datetime:Y-m-d H:i:s',
        'updated_at'=>'datetime:Y-m-d H:i:s'
    ];

    public function category():BelongsTo
    {
        return $this->belongsTo(Category::class,'kategori_id');
    }
}
