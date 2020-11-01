<?php

namespace App\Providers;
use App\Models\Panel\App_config;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // if (app()->environment('remote')) {
        //     URL::forceSchema('https');
        // }
        // URL::forceScheme('https');
        // view()->composer('*', function ($view) {
            // $data = array();
            // foreach (App_config::all() as $setting){
            //     $data[$setting->id] = $setting->value;
            // }
        //     $view->with('app_config', $data);
        // });
        // dd(App_config::all());
        view()->composer(
            '*',
            'App\Http\ViewComposers\ProfileComposer'
        );
    }
}
