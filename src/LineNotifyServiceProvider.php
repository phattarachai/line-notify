<?php


namespace Phattarachai\LineNotify;


use Carbon\Laravel\ServiceProvider;

class LineNotifyServiceProvider extends ServiceProvider
{

    public function boot()
    {
        $this->registerPublishables();
    }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/line.php', 'line');

        $this->app->singleton(Line::class, function () {
            $token = config('line.access_token');

            return new Line($token);
        });
    }

    protected function registerPublishables(): void
    {
        $this->publishes([
            __DIR__ . '/../config/media-library.php' => config_path('media-library.php'),
        ], 'config');
    }

}
