<?php namespace Gaus\Admin\Models;

use Illuminate\Database\Eloquent\Model;

class SettingGroup extends Model {

	protected $table = 'settings_groups';

	public $timestamps = false;

	protected $fillable = ['name', 'description', 'order'];

	public function settings()
	{
		return $this->hasMany('Gaus\Admin\Models\Setting', 'group_id');
	}
}
