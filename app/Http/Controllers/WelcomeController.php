<?php namespace App\Http\Controllers;

use Gaus\Admin\Models\News;
use Gaus\Admin\Models\Page;
use Gaus\Admin\Models\Catalog;
use Gaus\Admin\Models\Product;
use Settings;

class WelcomeController extends Controller {

	public function __construct()
	{
		//$this->middleware('guest');
	}

	public function index()
	{
		$page = with(new Page)->mainPage();

		view()->share('head_title', $page->title);
		view()->share('head_keywords', $page->keywords);
		view()->share('head_description', $page->description);

		$catalog_menu = Catalog::mainMenu()->get();
		$slider = Settings::get('main_slider');

		return view('pages.main', [
			'catalog_menu' => $catalog_menu,
			'slider' => $slider,
		]);
	}

	public function page($stage1, $stage2 = null)
	{
		$page = Page::where('alias', $stage1)->where('published', 1)->firstOrFail();

		view()->share('head_title', $page->title);
		view()->share('head_keywords', $page->keywords);
		view()->share('head_description', $page->description);

		return view('pages.page_text', ['page' => $page]);
	}
}
