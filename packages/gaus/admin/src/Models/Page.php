<?php namespace Gaus\Admin\Models;

use Illuminate\Database\Eloquent\Model;

class Page extends Model {

	protected $table = 'pages';

	protected $fillable = ['parent_id', 'name', 'text', 'alias', 'title', 'keywords', 'description', 'order', 'published'];

	public function parent()
	{
		return $this->belongsTo('Gaus\Admin\Models\Page', 'parent_id');
	}

	public function childrens()
	{
		return $this->hasMany('Gaus\Admin\Models\Page', 'parent_id');
	}

	public function settingGroups()
	{
		return $this->hasMany('Gaus\Admin\Models\SettingGroup', 'page_id');
	}

	public function galleries()
	{
		return $this->hasMany('Gaus\Admin\Models\Gallery', 'page_id');
	}

	public function catalog()
	{
		return $this->hasOne('Gaus\Admin\Models\Catalog', 'page_id');
	}

	public function scopePublic($query)
	{
		return $query->where('published', 1);
	}

	public function scopeMain($query)
	{
		return $query->where('parent_id', 1);
	}

	public function scopeSubMenu($query)
	{
		return $query->where('parent_id', $this->id)->public()->orderBy('order');
	}

	public function getUrlAttribute($value)
	{
		return route('default', ['page' => $this->alias]);
	}

	public function mainPage()
	{
		return $this->where('parent_id', 0)->public()->where('alias', '')->first();
	}
}
