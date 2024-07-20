<?php

namespace App\Business\Validation;

class ValidationRules
{
    public static function SalonValidator():array // salon validasyon kuralları
    {
        return [
            'salonAdi'=>'required|string',
            'tur_id'=>'required|integer'
        ];
    }

    public static function CustomerValidator():array // cari validasyon kuralları (açık hesap)
    {
        return [
                  'adi'=>'required|string',
                  'soyAdi'=>'required|string',
                  'gsm'=>'required|string',
                  'telefon'=>'required|string|max:10', // başında 0 yok
                  'adres'=>'required|string',
                  'tcNo'=>'required|numeric|max:11',
                  'bakiye'=>'required|decimal:10,2'
               ];
    }

    public function UserValidator():array // kullanıcı validasyon kuralları
    {
        return [''];
    }

    public static function IncomeValidator():array  // gelir validasyon kuralları
    {
        return [
                  'tutar'=>'required|decimal:10,2',
                  'tahsilatTuru'=>'required|integer',
                  'vardiya_id'=>'required|integer'
               ];
    }

    public static function PaymentCustomerValidator():array // cari tahsilat kuralları
    {
        return [
            'tutar'=>'required|decimal:10,2',
            'fisNo'=>'required|string',
            'tahsilatTuru'=>'required|integer',
            'carikart_id'=>'required|integer'
        ];
    }

}
