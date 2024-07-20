<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Menu extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table='menus';
    protected $fillable=['menuAdi','tutar','kategori_id'];

    protected $casts=[
        'created_at'=>'datetime:Y-m-d H:i:s',
        'updated_at'=>'datetime:Y-m-d H:i:s'
    ];

    public function rezervations():BelongsToMany
    {
        return $this->belongsToMany(Rezervation::class,'rezervation_menus','menu_id','rezervasyon_id');
    }

    public function category():BelongsTo
    {
        return $this->belongsTo(Category::class,'kategori_id');
    }

}
