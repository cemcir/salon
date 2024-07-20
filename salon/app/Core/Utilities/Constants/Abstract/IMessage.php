<?php

namespace App\Core\Utilities\Constants\Abstract;

interface IMessage
{
    public static function Success():string;
    public static function Error():string;
    public static function NotFound():string;
    public static function FileMaxSize():string; // Dosya Boyutu
    public static function FileNotExtensions():string; // Dosya Uzantısı
    public static function FilePathCreated():string; // Dosya Yolu Başarılı
    public static function FilePathNotCreated():string; // Dosya Yolu Başarısız
}
