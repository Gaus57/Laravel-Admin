<?php namespace Gaus\Admin\Models;

use Illuminate\Database\Eloquent\Model;

class Catalog extends Model {

	protected $table = 'catalogs';

	protected $fillable = ['parent_id', 'name', 'text', 'alias', 'title', 'keywords', 'description', 'order', 'published', 'on_main'];

	protected $casts = [
		'settings' => 'array',
	];

	public function parent()
	{
		return $this->belongsTo('Gaus\Admin\Models\Catalog', 'parent_id');
	}

	public function childrens()
	{
		return $this->hasMany('Gaus\Admin\Models\Catalog', 'parent_id');
	}

	public function products()
	{
		return $this->hasMany('Gaus\Admin\Models\Product', 'catalog_id');
	}

	public function scopePublic($query)
	{
		return $query->where('published', 1);
	}

	public function scopeOnMain($query)
	{
		return $query->where('on_main', 1);
	}

	public function scopeMainMenu($query)
	{
		return $query->public()->where('parent_id', 0)->orderBy('order');
	}

	public function getUrlAttribute($value)
	{
		return route('default', ['page' => $this->alias]);
	}

	public function bread()
	{
		$bread = [];
		$bread[$this->url] = $this->name;
		$catalog = $this;
		while ($catalog = $catalog->parent) {
			$bread[$catalog->url] = $catalog->name;
		}
		return array_reverse($bread, true);
	}
}
