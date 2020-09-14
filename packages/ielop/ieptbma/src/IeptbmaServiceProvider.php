<?php

namespace Ielop\Ieptbma;

use Illuminate\Support\ServiceProvider;
// use Ielop\Ieptbma\Controller\CadastroController;

class IeptbmaServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    // protected $defer = true;
    
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        // Load root for specific project
        $this->loadRoutesFrom(__DIR__.'/routes.php');

        // Load IEPTBMA Views
        $this->loadViewsFrom(__DIR__.'/Views', 'ieptbma');

        // Configuration of the project
        $this->publishes([
                __DIR__.'/assets' => public_path('ieptbma'),
            ], 'public');
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        // register our controller
        $this->app->make('Ielop\Ieptbma\Controllers\CadastroController');
        $this->app->make('Ielop\Ieptbma\Controllers\ContatoController');
        $this->app->make('Ielop\Ieptbma\Controllers\DownloadsController');
        $this->app->make('Ielop\Ieptbma\Controllers\EditaisController');
        $this->app->make('Ielop\Ieptbma\Controllers\EventosController');
        $this->app->make('Ielop\Ieptbma\Controllers\HomeController');
        $this->app->make('Ielop\Ieptbma\Controllers\MapaCartorioController');
        $this->app->make('Ielop\Ieptbma\Controllers\NoticiasController');
        $this->app->make('Ielop\Ieptbma\Controllers\PesquisaPublicaController');
    }
}
