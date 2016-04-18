<?php namespace Gaus\Admin\Models;

use Illuminate\Database\Eloquent\Model;

class Gallery extends Model {

	protected $table = 'galleries';

	protected $fillable = ['page_id', 'name', 'params', 'order'];

	protected $casts = [
		'params' => 'array',
	];

	public $timestamps = false;

	public function items()
	{
		return $this->hasMany('Gaus\Admin\Models\GalleryItem');
	}
}
