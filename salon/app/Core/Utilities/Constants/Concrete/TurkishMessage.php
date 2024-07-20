<?php

namespace App\Core\Utilities\Constants\Concrete;

use App\Core\Utilities\Constants\Abstract\IMessage;

class TurkishMessage implements IMessage
{
    public static function Success():string
    {
        return "İşlem Başarılı";
    }

    public static function Error():string
    {
        return "İşlem Sırasında Bir Hata Oluştu";
    }

    public static function NotFound():string
    {
        return "Kayıt Bulunamadı";
    }

    public static function FileMaxSize():string
    {
        return "Dosya Boyutu 20 MB tan Fazla Olamaz";
    }

    public static function FileNotExtensions():string
    {
        return "Dosya Uzantısı Uygun Değil";
    }

    public static function FilePathCreated():string
    {
        return "Dosya Yolu Başarıyla Oluşturuldu";
    }

    public static function FilePathNotCreated():string
    {
        return "Dosya Yolu Oluşturulurken Hata Meydana Geldi";
    }
}
