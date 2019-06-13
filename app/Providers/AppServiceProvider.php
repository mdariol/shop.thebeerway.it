<?php

namespace App\Providers;

use App\Services\FattureInCloud;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\ServiceProvider;
use League\Flysystem\Filesystem;
use League\Flysystem\WebDAV\WebDAVAdapter;
use Sabre\DAV\Client;

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
        Storage::extend('webdav', function ($app, $config) {
            $root = $config['root'];

            $config = [
                'baseUri' => $config['url'],
                'userName' => $config['user'],
                'password' => $config['password']
            ];

            $client = new Client($config);
            $adapter = new WebDAVAdapter($client, null);

            return new Filesystem($adapter);
        });

        Blade::directive('ClToLt', function($expression){
            return "<?php echo $expression/100?>";
        });
    }
}
