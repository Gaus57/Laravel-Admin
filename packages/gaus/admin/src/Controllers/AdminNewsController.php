<?php namespace Gaus\Admin\Controllers;
use Request;
use Validator;
use Text;
use Thumb;
use Image;
use Gaus\Admin\Models\News;

class AdminNewsController extends AdminController {

	public function getIndex()
	{
		$news = News::orderBy('date', 'desc')->get();

		return view('admin::news.main', ['news' => $news]);
	}

	public function getEdit($id = null)
	{
		if (!$id || !($article = News::find($id))) {
			$article = new News;
			$article->date = date('Y-m-d');
			$article->published = 1;
		}

		return view('admin::news.edit', ['article' => $article]);
	}

	public function postSave()
	{
		$id = Request::input('id');
		$data = Request::only(['date', 'name', 'announce', 'text', 'published', 'alias', 'title', 'keywords', 'description']);
		$image = Request::file('image');

		if (!$data['alias']) $data['alias'] = Text::translit($data['name']);
		if (!$data['title']) $data['title'] = $data['name'];
		if (!$data['published']) $data['published'] = 0;

		// валидация данных
		$validator = Validator::make(
		    $data,
		    [
		    	'name' => 'required',
		    	'date' => 'required',
		    ]
		);
		if ($validator->fails()) {
			return ['errors' => $validator->messages()];
		}

		// Загружаем изображение
		if ($image) {
			$file_name = md5(uniqid(rand(), true)) . '.' . $image->getClientOriginalExtension();
			$image->move(base_path() . News::UPLOAD_PATH, $file_name);
			Image::make(base_path() . News::UPLOAD_PATH . $file_name)
				->resize(1920, 1080, function ($constraint) {
				    $constraint->aspectRatio();
				    $constraint->upsize();
				})
				->save();
			Thumb::make(News::UPLOAD_URL . $file_name, News::$thumbs);
			$data['image'] = $file_name;
		}

		// сохраняем страницу
		$article = News::find($id);
		if (!$article) {
			$article = News::create($data);
			return ['redirect' => route('admin.news.edit', [$article->id])];
		} else {
			if ($article->image && isset($data['image'])) {
				@unlink(base_path() . News::UPLOAD_PATH . $article->image);
				foreach (News::$thumbs as $key => $value) {
					@unlink(base_path() . '/public' . Thumb::url(News::UPLOAD_URL . $article->image, $key));
				}
			}
			$article->update($data);
		}

		return ['msg' => 'Изменения сохранены.'];
	}

	public function postDelete($id)
	{
		$article = News::find($id);
		$article->delete();

		return ['success' => true];
	}
}
