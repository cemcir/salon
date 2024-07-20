<?php

namespace App\Business\Constants\Concrete;
use App\Business\Constants\Abstract\IMessage;

class TurkishMessage implements IMessage
{
    public function SalonAdded():string
    {
        return "Salon Kaydı Başarıyla Eklendi";
    }

    public function SalonNotAdded():string
    {
        return "Salon Kaydı Eklenirken Hata Oluştu";
    }

    public function SalonUpdated():string
    {
        return "Salon Kaydı Başarıyla Güncellendi";
    }

    public function SalonNotUpdated():string
    {
        return "Salon Kaydı Güncelleme Esnasında Hata Oluştu";
    }

    public function SalonDeleted(): string
    {
        return "Salon Kaydı Başarıyla Silindi";
    }

    public function SalonNotDeleted(): string
    {
        return "Salon Kaydı Silinme Esnasında Hata Oluştu";
    }

    public function SalonNotFound(): string
    {
        return "Salon Kaydı Bulunamadı";
    }

    public function SalonTypeAdded(): string
    {
        return "Salon Türü Başarıyla Kaydedildi";
    }

    public function SalonTypeNotAdded(): string
    {
        return "Salon Türü Eklenirken Hata Oluştu";
    }

    public function SalonTypeUpdated(): string
    {
        return "Salon Türü Başarıyla Güncellendi";
    }

    public function SalonTypeNotUpdated(): string
    {
        return "Salon Türü Güncellenirken Hata Oluştu";
    }

    public function SalonTypeSalonExist(): string
    {
        return "Salon Türüne Ait Salon Kaydı Mevcut";
    }

    public function SalonTypeDeleted(): string
    {
        return "Salon Türü Başarıyla Silindi";
    }

    public function SalonTypeNotFound(): string
    {
        return "Kayıtlı Salon Türü Bulunamadı";
    }
    public function SalonTypeNotDeleted(): string
    {
        return "Salon Türü Silinirken Hata Oluştu";
    }

    public function SalonAlreadyExist(): string
    {
        return "Salon Türüne Ait Salon Kaydı Mevcut";
    }

    public function RezervationAdded(): string
    {
        return "Rezervasyon Kaydı Başarıyla Tamamlandı";
    }

    public function RezervationNotAdded(): string
    {
        return "Rezervasyon Kaydı Eklenirken Hata Oluştu";
    }

    public function RezervationAlreadyExist(): string
    {
        return "Bu Tarih ve Saatler Arasında Rezervasyon Kaydı Mevcut";
    }

    public function RezervationMenuNotAdded(): string
    {
        return "Rezervasyon Menu Kaydı Eklenirken Hata Oluştu";
    }

    public function RezervationMenuAdded(): string
    {
        return "Rezervasyon Menü Kaydı Başarıyla Tamamlandı";
    }

    public function RezervationUpdate(): string
    {
        return "Rezervasyon Başarıyla Güncellendi";
    }

    public function RezervationNotUpdated(): string
    {
        return "Rezervasyon Güncellenirken Hata Oluştu";
    }

    public function RezervationMenuNotUpdated(): string
    {
        return "Rezervasyon Menüsü Güncellenirken Hata Oluştu";
    }

    public function RezervationMenuExist(): string
    {
        return "Rezervasyona Ait Menü Zaten Mevcut";
    }

    public function RezervationMenuUpdated(): string
    {
        return "Rezervasyon Menüsü Başarıyla Güncellendi";
    }

    public function RezervationMenuNotDeleted(): string
    {
        return "Rezervasyona Ait Menü Silinirken Hata Oluştu";
    }

    public function RezervationNotFound(): string
    {
        return "Rezervasyon Kaydı Bulunamadı";
    }

    public function PaymentNotAdded(): string
    {
        return "Tahsilat Kaydı Eklenirken Hata Oluştu";
    }

    public function PaymentAdded(): string
    {
        return "Tahsilat Kaydı Başarıyla Eklendi";
    }

    public function RezervationPaymentStateNotUpdate():string
    {
        return "Rezervasyon Ödeme Durumu Güncellenirken Hata Oluştu";
    }

    public function PaymentNotFound():string
    {
        return "Tahsilat Kaydı Bulunamadı";
    }

    public function PaymentNotDeleted(): string
    {
        return "Tahsilat Kaydı Silinirken Hata Oluştu";
    }

    public function PaymentDeleted(): string
    {
        return "Tahsilat Kaydı Başarıyla Silindi";
    }

    public function RezervationMenuNotFound():string
    {
        return "Rezervasyon Menu Kaydı Bulunamadı";
    }

    public function RezervationMenuDeleted():string
    {
        return "Rezervasyon Menü Kaydı Başarıyla Silindi";
    }

    public function ShiftAdded(): string
    {
        return "Vardiya Başarıyla Başlatıldı";
    }

    public function ShiftNotAdded(): string
    {
        return "Vardiya Başlatılırken Hata Oluştu";
    }

    public function ShiftClosed(): string
    {
        return "Vardiya Başarıyla Kapatıldı";
    }

    public function ShiftNotClosed(): string
    {
        return "Vardiya Kapatılırken Hata Oluştu";
    }

    public function ShiftNotFound(): string
    {
        return "Aktif Vardiya Kaydı Bulunamadı";
    }

    public function PaymentCustomerAdded(): string
    {
        return "Cari Tahsilat Kaydı Başarıyla Yapıldı";
    }

    public function CustomerExtreNotFound(): string
    {
        return "Cari Extre Kaydı Bulunamadı";
    }

    public function PaymentCustomerNotFound(): string
    {
        return "Cari Tahsilat Kaydı Bulunamadı";
    }

    public function CustomerDebtAdded(): string
    {
        return "Cari Ödeme Başarıyla Tamamlandı";
    }

    public function CustomerDebtNotAdded(): string
    {
        return "Cari Ödeme Kaydı Esnasında Hata Oluştu";
    }

    public function PaymentCustomerDeleted(): string
    {
        return "Cari Tahsilat Kaydı Başarıyla Silindi";
    }

    public function ExpenseAdded(): string
    {
        return "Gider Kaydı Başarıyla Tamamlandı";
    }

    public function MenuAlreadyExist(): string
    {
        return "Rezervasyona Ait Menü Kaydı Mevcut";
    }

    public function PaymentAlreadyExist(): string
    {
        return "Rezervasyona Ait Tahsilat Kaydı Mevcut";
    }

    public function RezervationDeleted(): string
    {
        return "Rezervasyon Kaydı Başarıyla Silindi";
    }

    public function RezervationNotDeleted(): string
    {
        return "Rezervasyon Kaydı Silinirken Hata Oluştu";
    }

    public function UserUpdated(): string
    {
        return "Kullanıcı Başarıyla Güncellendi";
    }

    public function UserNotUpdated(): string
    {
        return "Kullanıcı Güncellenirken Hata Oluştu";
    }

}
