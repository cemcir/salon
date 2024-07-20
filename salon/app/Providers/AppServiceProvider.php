<?php

namespace App\Providers;

use App\Business\Abstract\ICustomerService;
use App\Business\Abstract\IMenuService;
use App\Business\Abstract\IPaymentCustomerService;
use App\Business\Abstract\IPaymentService;
use App\Business\Abstract\IRezervationMenuService;
use App\Business\Abstract\IRezervationService;
use App\Business\Abstract\ISalonService;
use App\Business\Abstract\ISalonTypeService;
use App\Business\Abstract\IShiftService;
use App\Business\Abstract\IUserService;
use App\Business\Concrete\CustomerManager;
use App\Business\Concrete\IncomeManager;
use App\Business\Concrete\MenuManager;
use App\Business\Concrete\PaymentCustomerManager;
use App\Business\Concrete\PaymentManager;
use App\Business\Concrete\RezervationManager;
use App\Business\Concrete\RezervationMenuManager;
use App\Business\Concrete\SalonManager;
use App\Business\Concrete\SalonTypeManager;
use App\Business\Concrete\ShiftManager;
use App\Business\Concrete\UserManager;
use App\Business\Constants\Abstract\IMessage;
use App\Business\Constants\Concrete\TurkishMessage;
use App\DataAccess\Abstract\ICustomerDal;
use App\DataAccess\Abstract\IExpenseDal;
use App\DataAccess\Abstract\IMenuCategoryDal;
use App\DataAccess\Abstract\IMenuDal;
use App\DataAccess\Abstract\IncomeDal;
use App\DataAccess\Abstract\IPaymentCustomerDal;
use App\DataAccess\Abstract\IPaymentDal;
use App\DataAccess\Abstract\IRezervationDal;
use App\DataAccess\Abstract\IRezervationMenuDal;
use App\DataAccess\Abstract\ISafeDal;
use App\DataAccess\Abstract\ISalonDal;
use App\DataAccess\Abstract\ISalonTypeDal;
use App\DataAccess\Abstract\IShiftDal;
use App\DataAccess\Abstract\IUserDal;
use App\DataAccess\Concrete\Eloquent\ElCustomerDal;
use App\DataAccess\Concrete\Eloquent\ElExpenseDal;
use App\DataAccess\Concrete\Eloquent\ElIncomeDal;
use App\DataAccess\Concrete\Eloquent\ElMenuCategoryDal;
use App\DataAccess\Concrete\Eloquent\ElMenuDal;
use App\DataAccess\Concrete\Eloquent\ElPaymentCustomerDal;
use App\DataAccess\Concrete\Eloquent\ElPaymentDal;
use App\DataAccess\Concrete\Eloquent\ElRezervationDal;
use App\DataAccess\Concrete\Eloquent\ElRezervationMenuDal;
use App\DataAccess\Concrete\Eloquent\ElSafeDal;
use App\DataAccess\Concrete\Eloquent\ElSalonDal;
use App\DataAccess\Concrete\Eloquent\ElSalonTypeDal;
use App\DataAccess\Concrete\Eloquent\ElShiftDal;
use App\DataAccess\Concrete\Eloquent\ElUserDal;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register() // bağımlı enjeksiyonlar
    {
        $this->app->bind(IUserService::class,UserManager::class);
        $this->app->bind(IRezervationService::class,RezervationManager::class);
        $this->app->bind(IRezervationMenuService::class,RezervationMenuManager::class);
        $this->app->bind(IMenuService::class,MenuManager::class);
        $this->app->bind(ISalonTypeService::class,SalonTypeManager::class);
        $this->app->bind(ISalonService::class,SalonManager::class);
        $this->app->bind(IPaymentService::class,PaymentManager::class);
        $this->app->bind(ICustomerService::class,CustomerManager::class);
        $this->app->bind(IShiftService::class,ShiftManager::class);
        $this->app->bind(IPaymentCustomerService::class,PaymentCustomerManager::class);

        $this->app->bind(IUserDal::class,ElUserDal::class);
        $this->app->bind(IRezervationMenuDal::class,ElRezervationMenuDal::class);
        $this->app->bind(IRezervationDal::class,ElRezervationDal::class);
        $this->app->bind(ISalonDal::class,ElSalonDal::class);
        $this->app->bind(ISalonTypeDal::class,ElSalonTypeDal::class);
        $this->app->bind(IMenuDal::class,ElMenuDal::class);
        $this->app->bind(IPaymentDal::class,ElPaymentDal::class);
        $this->app->bind(IMessage::class,TurkishMessage::class);
        $this->app->bind(ICustomerDal::class,ElCustomerDal::class);
        $this->app->bind(IShiftDal::class,ElShiftDal::class);
        $this->app->bind(IncomeDal::class,ElIncomeDal::class);
        $this->app->bind(IExpenseDal::class,ElExpenseDal::class);
        $this->app->bind(ISafeDal::class,ElSafeDal::class);
        $this->app->bind(IMenuCategoryDal::class,ElMenuCategoryDal::class);
        $this->app->bind(IPaymentCustomerDal::class,ElPaymentCustomerDal::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot():void
    {
        ini_set('display_errors',1);
        ini_set('display_startup_errors',1);
        error_reporting(E_ALL);
    }

}
