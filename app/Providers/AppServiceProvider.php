<?php

namespace App\Providers;

use App\Models\Setting;
use App\Models\Activity;
use Illuminate\Support\Str;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Request;
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
    public function boot(Response $response): void
    {
        if(Schema::hasTable('activities'))
        {
            $statusCode = $response->getStatusCode();
            if(!$this->app->runningInConsole())
            {
                
                if(Str::contains(Request::fullUrl(), '/webmaster/')) 
                {
                    Activity::create([
                        'type' => 'webmaster_visit',
                        'url' => Request::fullUrl(),
                        'response' => $statusCode,
                        'refer' => Request::header('referer'),
                        'method' => Request::method(),
                        'gets' => json_encode(isset($_GET)?$_GET:[]),
                        'posts' => json_encode(isset($_POST)?$_POST:[]),
                        'cookies' => json_encode(isset($_COOKIE)?$_COOKIE:[]),
                        'ip' => Request::ip(),
                    ]);
                }
                else
                {
                    Activity::create([
                        'type' => 'visit',
                        'url' => Request::fullUrl(),
                        'response' => $statusCode,
                        'refer' => Request::header('referer'),
                        'method' => Request::method(),
                        'gets' => json_encode(isset($_GET)?$_GET:[]),
                        'posts' => json_encode(isset($_POST)?$_POST:[]),
                        'cookies' => json_encode(isset($_COOKIE)?$_COOKIE:[]),
                        'ip' => Request::ip(),
                    ]);
                }
            }
        }
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
