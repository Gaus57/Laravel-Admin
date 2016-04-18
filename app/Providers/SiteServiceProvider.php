<?php namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use View;
use Cart;
use Gaus\Admin\Models\Page;

class SiteServiceProvider extends ServiceProvider {

	/**
	 * Bootstrap any application services.
	 *
	 * @return void
	 */
	public function boot()
	{
		// пререндер для шаблона
        View::composer(['template'], function($view) {
            $main_menu = Page::orderBy('order')->public()->main()->get();
            $view->with('main_menu', $main_menu);
        });
	}

	/**
	 * Register any application services.
	 *
	 * This service provider is a great spot to register your various container
	 * bindings with the application. As you can see, we are registering our
	 * "Registrar" implementation here. You can add your own bindings too!
	 *
	 * @return void
	 */
	public function register()
	{
		//
	}

}
