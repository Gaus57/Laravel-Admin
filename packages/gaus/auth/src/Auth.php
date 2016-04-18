<?php namespace Gaus\Auth;

use Illuminate\Http\Response;
use Request;
use Session;
use Cookie;
use Gaus\Auth\Models\User;

class Auth
{
	protected static $user;

	const SES_KEY = 'auth_user';

	public static function init()
	{
		if (self::logedIn()) return true;
		$user = Session::get(self::SES_KEY);
		if ($user) {
			self::$user = $user;
			return true;
		}

		return self::cookieAuth();
	}

	public static function cookieAuth()
	{
		$user_id = Request::cookie('user_id');
		$remember_token = Request::cookie('remember_token');
		
		if ($user_id && $remember_token) {
			self::$user = User::where('id', $user_id)->where('remember_token', $remember_token)->first();
		}

		if (self::logedIn()) {
			Session::put(self::SES_KEY, self::$user);
			return true;
		}

		return false;
	}

	public static function login($login, $password)
	{
		$password = md5(md5($password));
		
		self::$user = User::where('username', $login)->where('password', $password)->first();
		
		if (self::logedIn()) {
			Session::put(self::SES_KEY, self::$user);
			return true;
		}
		
		return false;
	}

	public static function forceLogin($user)
	{
		self::$user = $user;

		if (self::logedIn()) {
			Session::put(self::SES_KEY, self::$user);
			return true;
		}
		
		return false;
	}

	public static function logout()
	{
		self::$user = null;
		Session::forget(self::SES_KEY);
	}

	public static function cookieRemember()
	{
		$cookie1 = Cookie::forever('user_id', self::$user->id);
		$cookie2 = Cookie::forever('remember_token', self::$user->remember_token);

		return [$cookie1, $cookie2];
	}

	public static function cookieForgot()
	{
		$cookie1 = Cookie::forget('user_id');
		$cookie2 = Cookie::forget('remember_token');

		return [$cookie1, $cookie2];
	}

	public static function logedIn()
	{
		return (bool)(self::$user && self::$user->id);
	}

	public static function user()
	{
		return self::$user;
	}
}
