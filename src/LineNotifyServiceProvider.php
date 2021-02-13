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
        $this->mergeConfigFrom(__DIR__ . '/../config/line-notify.php', 'line-notify');

        $this->app->singleton(Line::class, function () {
            $token = config('line-notify.access_token');

            if ($token === null) {
                throw new \Exception('Please specify line-notify access token in config/line-notify.php');
            }

            return new Line($token);
        });
    }

    protected function registerPublishables(): void
    {
        $this->publishes([
            __DIR__ . '/../config/line-notify.php' => config_path('line-notify.php'),
        ], 'config');
    }

}
