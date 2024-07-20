<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class PaymentCustomer extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table='payment_customers';
    protected $fillable=['tutar','aciklama','fisNo','hareket','vardiya_id','tahsilatTuru','tahsilat_id','carikart_id'];

    protected $casts=[
        'created_at'=>'datetime:Y-m-d H:i:s',
        'updated_at'=>'datetime:Y-m-d H:i:s'
    ];

    public function customer():BelongsTo
    {
        return $this->belongsTo(Customer::class,'carikart_id');
    }

}
