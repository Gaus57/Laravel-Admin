<?php namespace Gaus\Admin\Controllers;
use Request;
use Validator;
use Text;
use DB;
use Gaus\Admin\Models\Page;
use Gaus\Admin\Models\Setting;
use App\SiteHelper;


class AdminPagesController extends AdminController {

	public function getIndex()
	{
		$sitemap = Request::get('sitemap', null);
		if($sitemap) {
			SiteHelper::generateSitemap();
			$sitemap = view('admin::pages.sitemap');
		}
		$pages = Page::orderBy('order')->get();

		return view('admin::pages.main', ['pages' => $pages, 'content' => $sitemap]);
	}

	public function postEdit($id = null)
	{
		if (!$id || !($page = Page::findOrFail($id))) {
			$page = new Page;
			$page->parent_id = Request::input('parent');
		}
		// Загружаем настройки, если есть
		$setting_groups = [];
		if ($page->id) {
			$setting_groups = $page->settingGroups()->orderBy('order')->get();
		}
		$galleries = [];
		if ($page->id) {
			$galleries = $page->galleries()->orderBy('order')->get();
		}
		// Загружаем галереи, если есть

		$pages = Page::orderBy('order')->get();

		return view('admin::pages.edit', ['page' => $page, 'pages' => $pages, 'setting_groups' => $setting_groups, 'galleries' => $galleries]);
	}

	public function getEdit($id = null)
	{
		$pages = Page::orderBy('order')->get();

		return view('admin::pages.main', ['pages' => $pages, 'content' => $this->postEdit($id)]);
	}

	public function postSave()
	{
		$id = Request::input('id');
		$data = Request::only(['parent_id', 'name', 'text', 'alias', 'title', 'keywords', 'description', 'published']);
		if (!$data['published']) $data['published'] = 0;

		$page = Page::find($id);
		
		// Определяем правила валидации
		$rules = [
			'name' => 'required',
		];
		if ($page && $page->system == 0) $rules['alias'] = 'required|unique:pages,alias,'.$page->id;
		elseif (!$page && $data['alias']) $rules['alias'] = 'required|unique:pages';

		// валидация данных
		$validator = Validator::make($data, $rules);
		if ($validator->fails()) {
			return ['errors' => $validator->messages()];
		}

		// сохраняем страницу
		if (!$page) {
			$check_alias = false;
			if (!$data['alias']) {
				$data['alias'] = Text::translit($data['name']);
				$check_alias = DB::table('pages')->where('alias', $data['alias'])->first();
			}
			if (!$data['title']) $data['title'] = $data['name'];
			$data['order'] = Page::where('parent_id', $data['parent_id'])->max('order') + 1;
			$page = Page::create($data);
			if ($check_alias) {
				$page->alias = $page->id.'-'.$page->alias;
				$page->save();
			}
			return ['redirect' => route('admin.pages.edit', [$page->id])];
		} else {
			if ($page->system == 1) unset($data['alias']);
			if ($page->parent_id != $data['parent_id']) $data['order'] = Page::where('parent_id', $data['parent_id'])->max('order') + 1;
			$page->update($data);

			// сохраняем настройки
			$groups = Request::input('setting_group', []);
			if (!empty($groups)) {
				$settings_data = Request::input('setting', []);
				$settings = Setting::whereIn('group_id', $groups)->get();
				foreach ($settings as $setting) {
					AdminSettingsController::settingSave($setting, array_get($settings_data, $setting->id));
				}
				if (!empty($_FILES)) return ['redirect' => route('admin.pages.edit', [$page->id])];
			}
		}

		return ['success' => true, 'msg' => 'Изменения сохранены', 'row' => view('admin::pages.tree_item', ['item' => $page])->render()];
	}

	public function postReorder()
	{
		// изменеие родителя
		$id = Request::input('id');
		$parent = Request::input('parent');
		DB::table('pages')->where('id', $id)->update(array('parent_id' => $parent));
		// сортировка
		$sorted = Request::input('sorted', []);
		foreach ($sorted as $order => $id) {
			DB::table('pages')->where('id', $id)->update(array('order' => $order));
		}
		return ['success' => true];
	}

	public function postDelete($id)
	{
		$page = Page::findOrFail($id);
		if ($page->system == 1) {
			return ['success' => false, 'msg' => 'Невозможно удалить системную страницу!'];
		}
		$page->delete();

		return ['success' => true];
	}
}
