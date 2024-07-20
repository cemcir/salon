<?php

namespace App\Core\Utilities\Constants\Concrete;

use App\Core\Utilities\Constants\Abstract\IMessage;

class EnglishMessage implements IMessage
{

    public static function Success(): string
    {
        return "Operation is Succesfully";
    }

    public static function Error(): string
    {
        return "Operation is not Successfully";
    }

    public static function NotFound(): string
    {
        return "Record not Found";
    }

    public static function FileMaxSize(): string
    {
        return "file size can not be more than 20 MB";
    }

    public static function FileNotExtensions(): string
    {
        return "";
    }

    public static function FilePathCreated(): string
    {
        return "file path is created with succesfully";
    }

    public static function FilePathNotCreated(): string
    {
        return "created error while file path is creating";
    }
}
