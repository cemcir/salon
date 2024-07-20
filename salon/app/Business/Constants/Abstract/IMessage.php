<?php

namespace App\Business\Constants\Abstract;

interface IMessage
{
    public function SalonAdded():string;
    public function SalonTypeAdded():string;
    public function SalonTypeNotAdded():string;
    public function SalonNotAdded():string;
    public function SalonUpdated():string;
    public function SalonNotUpdated():string;
    public function SalonDeleted():string;
    public function SalonNotDeleted():string;
    public function SalonNotFound():string;
    public function SalonTypeUpdated():string;
    public function SalonTypeNotUpdated():string;
    public function SalonTypeSalonExist():String;
    public function SalonTypeDeleted():string;
    public function SalonTypeNotFound():string;
    public function SalonTypeNotDeleted():string;
    public function SalonAlreadyExist():String;
    public function RezervationAdded():String;
    public function RezervationNotAdded():String;
    public function RezervationAlreadyExist():String;
    public function RezervationMenuAdded():String;
    public function RezervationMenuNotAdded():String;
    public function RezervationUpdate():String;
    public function RezervationNotUpdated():String;
    public function RezervationMenuNotUpdated():String;
    public function RezervationMenuExist():String;
    public function RezervationMenuUpdated():string;
    public function RezervationMenuNotDeleted():string;
    public function RezervationNotFound():string;
    public function PaymentNotAdded():string;
    public function PaymentAdded():string;
    public function RezervationPaymentStateNotUpdate():string;
    public function PaymentNotFound():string;
    public function PaymentNotDeleted():String;
    public function PaymentDeleted():string;
    public function RezervationMenuDeleted():string;
    public function RezervationMenuNotFound():string;
    public function ShiftAdded():string;
    public function ShiftNotAdded():string;
    public function ShiftClosed():string;
    public function ShiftNotClosed():string;
    public function ShiftNotFound():string;
    public function PaymentCustomerAdded():string;
    public function CustomerExtreNotFound():string;
    public function PaymentCustomerNotFound():string;
    public function CustomerDebtAdded():string;
    public function CustomerDebtNotAdded():string;
    public function PaymentCustomerDeleted():string;
    public function ExpenseAdded():string;
    public function UserUpdated():string;
    public function UserNotUpdated():string;
    public function MenuAlreadyExist():string;
    public function PaymentAlreadyExist():string;
    public function RezervationDeleted():string;
    public function RezervationNotDeleted():string;
    public function RezervationAlreadyExistForSalon();
}
