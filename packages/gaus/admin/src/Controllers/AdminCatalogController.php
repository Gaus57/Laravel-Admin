<?php namespace Gaus\Admin\Controllers;
use Request;
use Validator;
use Text;
use DB;
use Image;
use Thumb;
use Gaus\Admin\Models\Catalog;
use Gaus\Admin\Models\Product;
use Gaus\Admin\Models\ProductImage;

class AdminCatalogController extends AdminController {

	public function getIndex()
	{
		$catalogs = Catalog::orderBy('order')->get();

		return view('admin::catalog.main', ['catalogs' => $catalogs]);
	}

	public function postProducts($catalog_id)
	{
		$catalog = Catalog::findOrFail($catalog_id);
		$products = $catalog->products()->orderBy('order')->get();

		return view('admin::catalog.products', ['catalog' => $catalog, 'products' => $products]);
	}

	public function getProducts($catalog_id)
	{
		$catalogs = Catalog::orderBy('order')->get();

		return view('admin::catalog.main', ['catalogs' => $catalogs, 'content' => $this->postProducts($catalog_id)]);
	}

	public function postCatalogEdit($id = null)
	{
		if (!$id || !($catalog = Catalog::findOrFail($id))) {
			$catalog = new Catalog;
			$catalog->parent_id = Request::input('parent');
		}
		$catalogs = Catalog::orderBy('order')->get();

		return view('admin::catalog.catalog_edit', ['catalog' => $catalog, 'catalogs' => $catalogs]);
	}

	public function getCatalogEdit($id = null)
	{
		$catalogs = Catalog::orderBy('order')->get();
		
		return view('admin::catalog.main', ['catalogs' => $catalogs, 'content' => $this->postCatalogEdit($id)]);
	}

	public function postCatalogSave()
	{
		$id = Request::input('id');
		$data = Request::only(['parent_id', 'name', 'text', 'alias', 'title', 'keywords', 'description', 'published', 'on_main']);
		if (!$data['published']) $data['published'] = 0;
		if (!$data['on_main']) $data['on_main'] = 0;

		// валидация данных
		$validator = Validator::make(
		    $data,
		    [
		    	'name' => 'required',
		    ]
		);
		if ($validator->fails()) {
			return ['errors' => $validator->messages()];
		}

		// сохраняем страницу
		$catalog = Catalog::find($id);
		if (!$catalog) {
			if (!$data['alias']) $data['alias'] = Text::translit($data['name']);
			if (!$data['title']) $data['title'] = $data['name'];
			$data['order'] = Catalog::where('parent_id', $data['parent_id'])->max('order') + 1;
			$catalog = Catalog::create($data);
			return ['redirect' => route('admin.catalog.catalogEdit', [$catalog->id])];
		} else {
			$catalog->update($data);
		}

		return ['success' => true, 'msg' => 'Изменения сохранены'];
	}

	public function postCatalogReorder()
	{
		// изменеие родителя
		$id = Request::input('id');
		$parent = Request::input('parent');
		DB::table('catalogs')->where('id', $id)->update(array('parent_id' => $parent));
		// сортировка
		$sorted = Request::input('sorted', []);
		foreach ($sorted as $order => $id) {
			DB::table('catalogs')->where('id', $id)->update(array('order' => $order));
		}
		return ['success' => true];
	}

	public function postCatalogDelete($id)
	{
		$catalog = Catalog::findOrFail($id);
		$catalog->delete();

		return ['success' => true];
	}

	public function postProductEdit($id = null)
	{
		if (!$id || !($product = Product::findOrFail($id))) {
			$product = new Product;
			$product->catalog_id = Request::input('catalog');
		}
		$catalogs = Catalog::orderBy('order')->get();

		return view('admin::catalog.product_edit', ['product' => $product, 'catalogs' => $catalogs]);
	}

	public function getProductEdit($id = null)
	{
		$catalogs = Catalog::orderBy('order')->get();
		
		return view('admin::catalog.main', ['catalogs' => $catalogs, 'content' => $this->postProductEdit($id)]);
	}

	public function postProductSave()
	{
		$id = Request::input('id');
		$data = Request::only(['catalog_id', 'name', 'text', 'price', 'image', 'alias', 'title', 'keywords', 'description', 'published']);
		if (!$data['published']) $data['published'] = 0;

		// валидация данных
		$validator = Validator::make(
		    $data,
		    [
		    	'name' => 'required',
		    ]
		);
		if ($validator->fails()) {
			return ['errors' => $validator->messages()];
		}

		// сохраняем страницу
		$product = Product::find($id);
		if (!$product) {
			if (!$data['alias']) $data['alias'] = Text::translit($data['name']);
			if (!$data['title']) $data['title'] = $data['name'];
			$data['order'] = Product::where('catalog_id', $data['catalog_id'])->max('order') + 1;
			$product = Product::create($data);
			return ['redirect' => route('admin.catalog.productEdit', [$product->id])];
		} else {
			$product->update($data);
		}

		return ['success' => true, 'msg' => 'Изменения сохранены'];
	}

	public function postProductReorder()
	{
		$sorted = Request::input('sorted', []);
		foreach ($sorted as $order => $id) {
			DB::table('catalogs_products')->where('id', $id)->update(array('order' => $order));
		}
		return ['success' => true];
	}

	public function postProductDelete($id)
	{
		$product = Product::findOrFail($id);
		foreach ($product->images as $item) {
			@unlink(base_path() . ProductImage::UPLOAD_PATH . $item->image);
			foreach (ProductImage::$thumbs as $key => $value) {
				@unlink(base_path() . '/public' . Thumb::url(ProductImage::UPLOAD_URL . $item->image, $key));
			}
			$item->delete();
		}
		$product->delete();

		return ['success' => true];
	}

	public function postProductImageUpload($product_id)
	{
		$product = Product::findOrFail($product_id);
		$images = Request::file('images');
		$items = [];
		if ($images) foreach ($images as $image) {
			$file_name = md5(uniqid(rand(), true)) . '.' . $image->getClientOriginalExtension();
			$image->move(base_path() . ProductImage::UPLOAD_PATH, $file_name);
			Image::make(base_path() . ProductImage::UPLOAD_PATH . $file_name)
				->resize(1920, 1080, function ($constraint) {
				    $constraint->aspectRatio();
				    $constraint->upsize();
				})
				->save();
			$order = ProductImage::where('product_id', $product_id)->max('order') + 1;
			$item = ProductImage::create(['product_id' => $product_id, 'image' => $file_name, 'order' => $order]);
			if (is_array($product->catalog->settings) && !empty($product->catalog->settings['thumbs'])) {
				Thumb::make(ProductImage::UPLOAD_URL . $file_name, $product->catalog->settings['thumbs']);
			} else {
				Thumb::make(ProductImage::UPLOAD_URL . $file_name, ProductImage::$thumbs);
			}
			$items[] = $item;
		}

		$html = '';
		foreach ($items as $item) {
			$html .= view('admin::catalog.product_image', ['image' => $item, 'active' => '']);
		}

		return ['html' => $html];
	}

	public function postProductImageDelete($id)
	{
		$item = ProductImage::findOrFail($id);
		@unlink(base_path() . ProductImage::UPLOAD_PATH . $item->image);
		foreach (ProductImage::$thumbs as $key => $value) {
			@unlink(base_path() . '/public' . Thumb::url(ProductImage::UPLOAD_URL . $item->image, $key));
		}
		$item->delete();

		return ['success' => true];
	}
}
