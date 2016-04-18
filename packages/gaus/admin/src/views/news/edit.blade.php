@extends('admin::template')

@section('scripts')
	<script type="text/javascript" src="/adminlte/plugins/ckeditor/ckeditor.js"></script>
	<script type="text/javascript" src="/adminlte/interface_news.js"></script>
@stop

@section('page_name')
	<h1>
		Новости
		<small>{{ $article->id ? 'Редактировать' : 'Новая' }}</small>
	</h1>
@stop

@section('breadcrumb')
	<ol class="breadcrumb">
		<li><a href="#"><i class="fa fa-dashboard"></i> Главная</a></li>
		<li><a href="{{ route('admin.news') }}">Новости</a></li>
		<li class="active">{{ $article->id ? 'Редактировать' : 'Новая' }}</li>
	</ol>
@stop

@section('content')
	<form action="{{ route('admin.news.save') }}" onsubmit="return newsSave(this, event)">
		<input type="hidden" name="id" value="{{ $article->id }}">

		<div class="nav-tabs-custom">
			<ul class="nav nav-tabs">
				<li class="active"><a href="#tab_1" data-toggle="tab">Параметры</a></li>
				<li><a href="#tab_2" data-toggle="tab">Текст</a></li>
				<li><a href="#tab_3" data-toggle="tab">SEO</a></li>
			</ul>
			<div class="tab-content">
				<div class="tab-pane active" id="tab_1">
					
					<div class="form-group" style="width:160px;">
						<label for="article-year">Дата</label>
						<input id="article-year" class="form-control" type="date" name="date" value="{{ $article->date }}">
					</div>

					<div class="form-group">
						<label for="article-name">Название</label>
						<input id="article-name" class="form-control" type="text" name="name" value="{{ $article->name }}">
					</div>

					<div class="form-group">
						<label for="article-image">Изображение</label>
						<input id="article-image" type="file" name="image" value="" onchange="return newsImageAttache(this, event)">
						<div id="article-image-block">
							@if ($article->image)
								<img class="img-polaroid" src="{{ $article->thumb(1) }}" height="100" data-image="{{ $article->image_src }}" onclick="return popupImage($(this).data('image'))">
							@else
								<p class="text-yellow">Изображение не загружено.</p>
							@endif
						</div>
					</div>

					<div class="form-group">
						<label>
							<input type="checkbox" class="minimal" name="published" value="1" {{ $article->published == 1 ? 'checked' : '' }}>
							Показывать новость
						</label>
					</div>

					
				</div>

				<div class="tab-pane" id="tab_2">
					<div class="form-group">
						<label for="article-announce">Краткое описание</label>
						<textarea id="article-announce" class="form-control" name="announce" rows="3">{{ $article->announce }}</textarea>
					</div>

					<div class="form-group">
						<label>Текст</label>
						<textarea id="editor1" name="text" rows="10" cols="80">{{ $article->text }}</textarea>
						<script type="text/javascript">startCkeditor('editor1');</script>
					</div>
				</div>

				<div class="tab-pane" id="tab_3">
					<div class="form-group">
						<label for="article-alias">Alias</label>
						<input id="article-alias" class="form-control" type="text" name="alias" value="{{ $article->alias }}">
					</div>

					<div class="form-group">
						<label for="article-title">Title</label>
						<input id="article-title" class="form-control" type="text" name="title" value="{{ $article->title }}">
					</div>

					<div class="form-group">
						<label for="article-keywords">Keywords</label>
						<textarea id="article-keywords" class="form-control" name="keywords" rows="3">{{ $article->keywords }}</textarea>
					</div>

					<div class="form-group">
						<label for="article-description">Description</label>
						<textarea id="article-description" class="form-control" name="description" rows="3">{{ $article->description }}</textarea>
					</div>
				</div>
			</div>

			<div class="box-footer">
    			<button type="submit" class="btn btn-primary">Сохранить</button>
    		</div>
		</div>
	</form>
@stop