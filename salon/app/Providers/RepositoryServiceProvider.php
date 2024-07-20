<?php

namespace App\Providers;

use App\Business\Abstract\ISalonService;
use App\Business\Concrete\SalonManager;
use App\Business\Constants\Abstract\IMessage;
use App\Business\Constants\Concrete\TurkishMessage;
use App\Core\DataAccess\Eloquent\EloquentRepositoryBase;
use App\DataAccess\Abstract\ISalonDal;
use App\DataAccess\Concrete\Eloquent\ElSalonDal;
use App\IEloquentRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //$this->app->bind(IEloquentRepository::class,BaseRepository::class);
        //$this->app->bind(IFormRepository::class,FormRepository::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
