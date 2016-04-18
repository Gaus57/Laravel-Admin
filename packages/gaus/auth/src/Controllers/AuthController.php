<?php namespace Gaus\Auth\Controllers;
use App\Http\Controllers\Controller;
use Request;
use Response;
use Gaus\Auth\Models\User;
use Auth;
use Cookie;

class AuthController extends Controller {

	public function __construct()
	{
		$this->middleware('guest.gaus');
	}

	public function index()
	{
		if (Request::isMethod('post')) {
			$username = Request::input('username');
			$password = Request::input('password');
			$remember = (bool)Request::input('remember');
			if (!$username || !$password) {
				return redirect('auth')->withInput(['error' => 'Не заполнены обязательные поля!']);
			}
			if (Auth::login($username, $password)) {
				if ($remember) {
					list($cookie1, $cookie2) = Auth::cookieRemember();

					return redirect('admin')->withCookie($cookie1)->withCookie($cookie2);
				}

		        return redirect('admin');
			} else {
				return redirect('auth')->withInput(['error' => 'Не верные имя пользователя или пароль!']);
			}
		} else {
			Auth::logout();
			$error = Request::input('error');
			$response = response(view('auth::login', ['error' => $error]));
	        list($cookie1, $cookie2) = Auth::cookieForgot();

	        return $response->withCookie($cookie1)->withCookie($cookie2);
		}
	}
}
