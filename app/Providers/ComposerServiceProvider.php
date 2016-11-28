<?php

namespace App\Providers;

use App\Models\Business;
use Illuminate\Support\ServiceProvider;

class ComposerServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->composeBusiness();
        $this->composeAreaInfo();
        $this->composeSeasonInfo();
        $this->composeCustomerInfo();
        $this->composeUserInfo();
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    private function composeBusiness()
    {
        view()->composer('templates.composers.businessSelect', 'App\Http\Composers\BusinessSelectComposer');
    }

    private function composeAreaInfo()
    {
        view()->composer('templates.composers.areaSelect', 'App\Http\Composers\AreaSelectComposer');
    }

    private function composeSeasonInfo()
    {
        view()->composer('templates.composers.seasonSelect', 'App\Http\Composers\SeasonSelectComposer');
    }

    private function composeCustomerInfo()
    {
        view()->composer('templates.composers.customerSelect', 'App\Http\Composers\CustomerSelectComposer');

    }

    private function composeUserInfo()
    {
        view()->composer('templates.composers.userSelect', 'App\Http\Composers\UserSelectComposer');

    }

}
