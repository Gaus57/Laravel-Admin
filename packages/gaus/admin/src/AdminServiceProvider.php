<?php namespace Gaus\Admin;

use Illuminate\Support\ServiceProvider;
use View;
use DB;
use Auth;

class AdminServiceProvider extends ServiceProvider {

	/**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        // регистрируем namespace для файлов представлений
        $this->loadViewsFrom(__DIR__.'/views', 'admin');

        require __DIR__.'/routes.php';
    }

    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function register()
    {
        //
    }

}
