<?php

namespace App\Business\Validation;

class Keys
{
    public static function Salon():array // salon
    {
        return ['salonAdi','tur_id'];
    }

    public static function Rezervation():array // rezervasyon
    {
        return ['kiraTutari','menuTutari','girisSaat','cikisSaat','rezervasyonTarih','rezervasyonNotu','carikart_id','user_id','davetli'];
    }

    public static function CustomerPayment():array // cari tahsilat
    {
        return ['carikart_id','tutar','tahsilatTuru','aciklama','fisNo'];
    }
    public static function Safe():array // kasa
    {
        return ['tutar','tahsilatTuru','carikart_id','tahsilat_id'];
    }
    public static function Income():array // gelir
    {
        return ['tutar','tahsilatTuru','carikart_id','tahsilat_id'];
    }
    public static function Payment():array // tahsilat
    {
        return ['tutar','tahsilatTuru','rezervasyon_id','user_id'];
    }
    public static function CustomerDebt():array // cari borcu
    {
        return ['tutar','aciklama','tahsilatTuru','carikart_id','fisNo'];
    }
    public static function TransferRecord():array // cari devir kaydı
    {
        return ['tutar','aciklama','hareket','carikart_id'];
    }
    public static function Expense():array // gider
    {
        return ['tutar','tahsilatTuru','kategori_id'];
    }
    public static function RezervationSearch():array // rezervasyon arama
    {
        return ['girisSaat','cikisSaat','tarih','baslangic','limit'];
    }
    public static function UserForUpdate():array // kullanıcı
    {
        return ['name','id'];
    }

}
