<?php

namespace App\Providers;

use App\Models\Setting;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if(Schema::hasTable('settings'))
        {
            $settings = Setting::all();
            foreach ($settings as $setting) {
                
                if(strpos($setting->title, "%%") !== false){
                    $key = explode('%%', $setting->title)[0];
                    $content = array_merge(
                        config('settings.'.$key),
                        array(explode('%%', $setting->title)[1] => $setting->content),
                    );
                    config(['settings.'.$key => $content]);
                }else{
                    $key = $setting->title;
                    config(['settings.'.$key => $setting->content]);
                }
            }
        }
    }
}
