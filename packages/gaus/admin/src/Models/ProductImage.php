<?php namespace Gaus\Admin\Models;

use Illuminate\Database\Eloquent\Model;
use Thumb;

class ProductImage extends Model {

	protected $table = 'catalogs_products_images';

	protected $fillable = ['product_id', 'image', 'order'];

	public $timestamps = false;

	const UPLOAD_PATH = '/public/uploads/products/';
	const UPLOAD_URL = '/uploads/products/';

	public static $thumbs = [
		1 => '210x243',
	];

	public function getSrcAttribute($value)
	{
		return $this->image ? url(self::UPLOAD_URL . $this->image) : null;
	}

	public function thumb($thumb)
	{
		return $this->image ? url(Thumb::url(self::UPLOAD_URL . $this->image, $thumb)) : null;
	}
}
