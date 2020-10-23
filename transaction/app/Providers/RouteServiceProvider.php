<?php

namespace App\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'App\Http\Controllers';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        Route::macro('adminGenerator', function ($model, $controller) {

            Route::get($model . '/exportExcel', $controller . '@exportExcel')->name($model . ".exportExcel");
            Route::post($model . '/filter', $controller . '@filter')->name($model . ".filter");
            Route::post($model . '/batchAction', $controller . '@batchAction')->name($model . ".batchAction");

            Route::resource($model, $controller);
        });

        Route::macro('adminGeneratorParent', function ($model, $controller) {

            Route::get($model . '/exportExcel/{pid}', $controller . '@exportExcel')->name($model . ".exportExcel");
            Route::post($model . '/filter/{pid}', $controller . '@filter')->name($model . ".filter");
            Route::post($model . '/batchAction/{pid}', $controller . '@batchAction')->name($model . ".batchAction");


            Route::get($model . '/create/{pid}', $controller . '@create')->name($model . ".create");

            Route::get($model . '/{' . $model . '}/edit', $controller . '@edit')->name($model . ".edit");

            Route::patch($model . '/{' . $model . '}', $controller . '@update')->name($model . ".update");
            Route::put($model . '/{' . $model . '}', $controller . '@update')->name($model . ".update");
            Route::delete($model . '/{' . $model . '}', $controller . '@destroy')->name($model . ".destroy");
            Route::get($model . '/{' . $model . '}/show', $controller . '@show')->name($model . ".show");
            Route::get($model . '/{' . $model . '}/back', $controller . '@backToParent')->name($model . ".back");

            Route::get($model . '/{pid}', $controller . '@index')->name($model . ".index");
            Route::post($model . '/{pid}', $controller . '@store')->name($model . ".store");

        });

        parent::boot();
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {
        $this->mapApiRoutes();

        $this->mapWebRoutes();

        //
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapWebRoutes()
    {
        Route::middleware('web')
            ->namespace($this->namespace)
            ->group(base_path('routes/web.php'));
    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapApiRoutes()
    {
        Route::prefix('api')
            ->middleware('api')
            ->namespace($this->namespace)
            ->group(base_path('routes/api.php'));
    }
}
