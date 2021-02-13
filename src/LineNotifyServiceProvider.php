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
        $this->mergeConfigFrom(__DIR__ . '/../config/media-library.php', 'media-library');

//        $this->app->singleton(MediaRepository::class, function () {
//            $mediaClass = config('media-library.media_model');
//
//            return new MediaRepository(new $mediaClass);
//        });

//        $this->registerCommands();
    }

    protected function registerPublishables(): void
    {
        $this->publishes([
            __DIR__ . '/../config/media-library.php' => config_path('media-library.php'),
        ], 'config');

        if (!class_exists('CreateMediaTable')) {
            $this->publishes([
                __DIR__ . '/../database/migrations/create_media_table.php.stub' => database_path('migrations/' . date('Y_m_d_His',
                        time()) . '_create_media_table.php'),
            ], 'migrations');
        }

        $this->publishes([
            __DIR__ . '/../resources/views' => resource_path('views/vendor/media-library'),
        ], 'views');
    }

}
