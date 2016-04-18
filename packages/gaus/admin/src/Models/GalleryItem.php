<?php namespace Gaus\Admin\Models;

use Illuminate\Database\Eloquent\Model;
use Thumb;

class GalleryItem extends Model {

	protected $table = 'galleries_items';

	protected $fillable = ['gallery_id', 'image', 'data', 'order'];

	protected $casts = [
		'data' => 'array',
	];

	public $timestamps = false;

	const UPLOAD_PATH = '/public/uploads/gallery/';
	const UPLOAD_URL = '/uploads/gallery/';

	public static $thumbs = [
		1 => '228x213|fit',
	];

	public function gallery()
	{
		return $this->belongsTo('Gaus\Admin\Models\Gallery');
	}

	public function getSrcAttribute($value)
	{
		return $this->image ? url(self::UPLOAD_URL . $this->image) : null;
	}

	public function thumb($thumb)
	{
		return $this->image ? url(Thumb::url(self::UPLOAD_URL . $this->image, $thumb)) : null;
	}
}
