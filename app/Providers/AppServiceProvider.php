<?php

namespace App\Providers;

use App\Services\FattureInCloud;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(FattureInCloud::class, function () {
            return new FattureInCloud(
              config('services.fatture_in_cloud.key'),
              config('services.fatture_in_cloud.secret')
            );
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Blade::directive('ClToLt', function($expression){
            return "<?php echo $expression/100?>";
        });
    }
}
