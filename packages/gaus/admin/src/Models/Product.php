<?php namespace Gaus\Admin\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Thumb;

class Product extends Model {

	use SoftDeletes;

	protected $table = 'catalogs_products';

	protected $fillable = ['catalog_id', 'name', 'text', 'price', 'image', 'alias', 'title', 'keywords', 'description', 'order', 'published'];

	const UPLOAD_PATH = '/public/uploads/products/';
	const UPLOAD_URL = '/uploads/products/';

	public static $thumbs = [
		1 => '210x243',
	];

	public function catalog()
	{
		return $this->belongsTo('Gaus\Admin\Models\Catalog', 'catalog_id');
	}

	public function images()
	{
		return $this->hasMany('Gaus\Admin\Models\ProductImage', 'product_id');
	}

	public function scopePublic($query)
	{
		return $query->where('published', 1);
	}

	public function scopeOnMain($query)
	{
		return $query->where('on_main', 1);
	}

	public function getImageSrcAttribute($value)
	{
		return $this->image ? url(self::UPLOAD_URL . $this->image) : null;
	}

	public function thumb($thumb)
	{
		return $this->image ? url(Thumb::url(self::UPLOAD_URL . $this->image, $thumb)) : null;
	}

	public function url($catalog_alias = null)
	{
		if ($catalog_alias === null) $catalog_alias = $this->catalog->alias;
		return route('catalog', ['category' => $catalog_alias, 'product' => $this->alias]);
	}
}
