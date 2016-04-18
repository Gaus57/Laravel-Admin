<?php
/**
 * Created by PhpStorm.
 * User: јндрей
 * Date: 06.11.2015
 * Time: 12:32
 */

namespace App;
use Fanky\Admin\Models\Catalog as Catalog;
use Fanky\Admin\Models\Collection as Collection;
use Cache;
use Fanky\Admin\Models\Page;
use Fanky\Admin\Models\Redirect;
use Fanky\Admin\Models\Product;
use Fanky\Admin\Models\News;
use App\Sitemap as Sitemap;
use Response;

class SiteHelper {
	/**
	 * ‘ункци€ возвращает окончание дл€ множественного числа слова на основании числа и массива окончаний
	 * @param  $number Integer „исло на основе которого нужно сформировать окончание
	 * @param  $endingArray  Array ћассив слов или окончаний дл€ чисел (1, 4, 5),
	 *         например array('€блоко', '€блока', '€блок')
	 * @return String
	 */
	public static function getNumEnding($number, $endingArray)
	{
		$number = $number % 100;
		if ($number>=11 && $number<=19) {
			$ending=$endingArray[2];
		}
		else {
			$i = $number % 10;
			switch ($i)
			{
				case (1): $ending = $endingArray[0]; break;
				case (2):
				case (3):
				case (4): $ending = $endingArray[1]; break;
				default: $ending=$endingArray[2];
			}
		}
		return $ending;
	}

	public static function getRedirects($from = null){
		$redirects = Cache::get('redirects', []);
		if(!$redirects){
			$redirects_arr = Redirect::all(['from','to','code']);
			foreach($redirects_arr as $item){
				$redirects[$item->from] = $item;
			}
			Cache::add('redirects', $redirects, 1);
		}
		if(!is_null($from)){
			return isset($redirects[$from])? $redirects[$from]: null;
		} else {
			return $redirects;
		}
	}

	public static function generateSitemap(){
		$map = new Sitemap('');

		//страницы
		$pages = Page::wherePublished(1)->get();
		foreach ($pages as $page) {
			$map->add_url($page->url, $page->updated_at);
		}
/*
		//разделы каталога
		$catalogs = Catalog::wherePublished(1)->get();
		foreach ($catalogs as $catalog) {
			$map->add_url($catalog->url, $catalog->updated_at);
		}

		//товары
		$products = Product::wherePublished(1)->get();
		foreach ($products as $product) {
			$map->add_url($product->url, $product->updated_at);
		}

		//news
		$news = News::wherePublished(1)->get();
		foreach($news as $n){
			$map->add_url($n->url, $n->updated_at);
		}
*/
		$map->save();
		if (\App::isLocal()) {
			$status = 200;
			$header['Content-Type'] = 'application/xml';

			return Response::make($map->get_raw(), $status, $header);
		}
	}
}