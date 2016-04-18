<?php namespace Gaus\Auth\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Model {

	use SoftDeletes;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['name', 'username', 'email', 'password', 'phone', 'role', 'status'];

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = ['password', 'remember_token'];

	public static $roles = [
		0 => '',
		90 => 'Менеджер',
		100 => 'Администратор',
	];

	public static $statuses = [
		1 => 'Активный',
		10 => 'Бан',
	];

	public function setPasswordAttribute($value)
	{
		$this->attributes['password'] = md5(md5($value));
	}

	public function getRoleNameAttribute($value)
	{
		return isset(self::$roles[$this->attributes['role']]) ? self::$roles[$this->attributes['role']] : null;
	}

	public function getStatusNameAttribute($value)
	{
		return isset(self::$statuses[$this->attributes['status']]) ? self::$statuses[$this->attributes['status']] : null;
	}
}
