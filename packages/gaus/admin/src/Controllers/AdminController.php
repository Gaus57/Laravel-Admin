<?php namespace Gaus\Admin\Controllers;
use App\Http\Controllers\Controller;
use Request;
use Validator;
use Gaus\Auth\Models\User;
use Auth;

use Gaus\Admin\Models\Participant;
use Gaus\Admin\Models\GalleryItem;
use Gaus\Admin\Models\News;
use Gaus\Admin\Models\Sponsor;
use Gaus\Admin\Models\Specialist;
use Image;
use Thumb;

class AdminController extends Controller {
	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->middleware('auth.gaus');
	}

	public function main()
	{
		return view('admin::main');
	}
}
