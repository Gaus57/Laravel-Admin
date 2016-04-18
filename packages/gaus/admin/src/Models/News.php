<?php namespace Gaus\Admin\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Thumb;

class News extends Model {

	use SoftDeletes;

	protected $table = 'news';

	protected $fillable = ['name', 'image', 'published', 'date', 'announce', 'text', 'alias', 'title', 'keywords', 'description'];

	const UPLOAD_PATH = '/public/uploads/news/';
	const UPLOAD_URL = '/uploads/news/';

	public static $thumbs = [
		1 => '156x110',
		2 => '285x187',
		3 => '325x238',
	];

	public function scopePublic($query)
	{
		return $query->where('published', 1);
	}

	public function getImageSrcAttribute($value)
	{
		return $this->image ? url(self::UPLOAD_URL . $this->image) : null;
	}

	public function getUrlAttribute($value)
	{
		return route('news', ['alias' => $this->alias]);
	}

	public function dateFormat($format = 'd.m.Y')
	{
		if (!$this->date) return null;
		return date($format, strtotime($this->date));
	}

	public function thumb($thumb)
	{
		return $this->image ? url(Thumb::url(self::UPLOAD_URL . $this->image, $thumb)) : null;
	}
}
