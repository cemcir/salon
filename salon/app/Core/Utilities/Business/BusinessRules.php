<?php

namespace App\Core\Utilities\Business;

// Örneğin Salon Eklerken Aynı Salon Tekrar Varmı Gibi Varsa İşlemi Durdur
class BusinessRules // Sunucu Bazlı İş Kuralları Yazmak İçin Kullandık
{
    public static function Run(array $logics) {

        foreach ($logics as $logic) {
            if(!$logic->Status()) {
                return $logic;
            }
        }
        return null;
    }

}
