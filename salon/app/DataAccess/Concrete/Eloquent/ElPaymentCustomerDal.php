<?php

namespace App\DataAccess\Concrete\Eloquent;

use App\Business\Concrete\PaymentCustomerManager;
use App\Core\DataAccess\Eloquent\EloquentRepositoryBase;
use App\DataAccess\Abstract\IPaymentCustomerDal;
use App\Models\PaymentCustomer;

class ElPaymentCustomerDal extends EloquentRepositoryBase implements IPaymentCustomerDal
{
    public function __construct(PaymentCustomer $paymentCustomer)
    {
        parent::__construct($paymentCustomer);
    }

    public function GetExtre(int $cariId,int $start,int $limit) // cari extre
    {
        //$stmt=$conn->prepare("SELECT * FROM payment_customers WHERE cari_id=:cari_id
        //                      ORDER BY id DESC
        //                      LIMIT :baslangic,:uzunluk");

        //$stmt->bindParam(':cari_id',$cari_id,PDO::PARAM_INT);
        //$stmt->bindPAram(':baslangic',$baslangic,PDO::PARAM_INT);
        //$stmt->bindParam(':uzunluk',$uzunluk,PDO::PARAM_INT);

        //$stmt->execute();
        //$stmt->fetchAll(PDO::FETCH_ASSOC);

        return PaymentCustomer::where('carikart_id',$cariId)
                              ->orderBy('id','DESC')
                              ->offset($start)
                              ->limit($limit)
                              ->get();
    }

    public function TotalPayment(int $cariId) // toplam tahsilat
    {
        return PaymentCustomer::where([['carikart_id',$cariId],
                                       ['hareket','1']
                                      ])->sum('tutar');
    }

    public function TotalSpend(int $cariId) // toplam harcama 2 borç 1 alacak
    {
        //$stmt=$baglanti->prepare("SELECT SUM(tutar) AS tutar
        //FROM payment_customers WHERE cari_id=:cari_id AND hareket='2' ")
        //$stmt->bindParam(':cari_id',$cari_id,PDO::PARAM_INT);
        //$stmt->execute();

        //return $stmt->fetch(PDO::FETCH_ASSOC);

        return PaymentCustomer::where([['carikart_id',$cariId],
                                       ['hareket','2']
                                      ])->sum('tutar');
    }

    public function GetExtreCount(int $cariId):int
    {
        return PaymentCustomer::where('carikart_id',$cariId)->count('id');
    }

    public function GetByPaymentId(int $paymentId)
    {
        return PaymentCustomer::where('tahsilat_id',$paymentId)->first();
    }

}
