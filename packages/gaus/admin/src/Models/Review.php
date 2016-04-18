<?php namespace Gaus\Admin\Models;

use Illuminate\Database\Eloquent\Model;
use Gaus\Admin\YouTube;

class Review extends Model {

	protected $table = 'reviews';

	protected $fillable = ['type', 'text', 'adress', 'video', 'on_main', 'order'];

	public static $types = [
		'windows' => 'Пластиковые окна',
		'balcony' => 'Лоджии и балконы',
		'dveri' => 'Сейф-двери',
	];

	public function scopeOnMain($query)
	{
		return $query->where('on_main', 1);
	}

	public function getTypeNameAttribute($value)
	{
		return array_get(self::$types, $this->type);
	}

	public function getVideoSrcAttribute($value)
	{
		return $this->video ? YouTube::src($this->video) : null;
	}

	public function getVideoUrlAttribute($value)
	{
		return $this->video ? YouTube::url($this->video) : null;
	}

	public function getVideoThumbAttribute($value)
	{
		return $this->video ? YouTube::thumb($this->video) : null;
	}
}
