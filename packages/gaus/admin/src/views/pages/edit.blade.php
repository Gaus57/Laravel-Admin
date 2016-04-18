@section('page_name')
	<h1>Структура сайта
		<small>{{ $page->id ? 'Редактировать страницу' : 'Новая страница' }}</small>
	</h1>
@stop

<form action="{{ route('admin.pages.save') }}" onsubmit="return pageSave(this, event)">
	<input id="page-id" type="hidden" name="id" value="{{ $page->id }}">

	<div class="nav-tabs-custom">
		<ul class="nav nav-tabs">
			<li class="active"><a href="#tab_1" data-toggle="tab">Параметры</a></li>
			<li><a href="#tab_2" data-toggle="tab">Текст</a></li>
			<li><a href="#tab_3" data-toggle="tab">SEO</a></li>
			@if (count($setting_groups))
				<li class="dropdown">
					<a class="dropdown-toggle" data-toggle="dropdown" href="#" aria-expanded="true">Настройки <span class="caret"></span></a>
					<ul class="dropdown-menu">
						@foreach ($setting_groups as $item)
							<li><a href="#tab_setting_{{ $item->id }}" data-toggle="tab">{{ $item->name }}</a></li>
						@endforeach
					</ul>
				</li>
			@endif
			@if (count($galleries))
				<li class="dropdown">
					<a class="dropdown-toggle" data-toggle="dropdown" href="#" aria-expanded="true">Галереи <span class="caret"></span></a>
					<ul class="dropdown-menu">
						@foreach ($galleries as $item)
							<li><a href="#tab_gallery_{{ $item->id }}" data-toggle="tab">{{ $item->name }}</a></li>
						@endforeach
					</ul>
				</li>
			@endif
		</ul>
		<div class="tab-content">
			<div class="tab-pane active" id="tab_1">
				
				<div class="form-group">
					<label for="page-name">Название</label>
					<input id="page-name" class="form-control" type="text" name="name" value="{{ $page->name }}">
				</div>

				<div class="form-group" style="width:400px;">
					<label for="page-parent">Родительская страница</label>
					<select id="page-parent" class="form-control" name="parent_id">
						<option value="0">--корень сайта--</option>
						@foreach ($pages as $item)
							@if ($item->id != $page->id)
								<option value="{{ $item->id }}" {{ $page->parent_id == $item->id ? 'selected' : '' }}>{{ $item->name }}</option>
							@endif
						@endforeach
					</select>
				</div>

				<div class="form-group">
					<label>
						<input type="checkbox" class="minimal" name="published" value="1" {{ $page->published == 1 ? 'checked' : '' }}>
						Показывать страницу
					</label>
				</div>

				
			</div>

			<div class="tab-pane" id="tab_2">
				<div class="form-group">
					<textarea id="editor1" name="text" rows="10" cols="80">{{ $page->text }}</textarea>
					<script type="text/javascript">startCkeditor('editor1');</script>
				</div>
			</div>

			<div class="tab-pane" id="tab_3">
				<div class="form-group">
					<label for="page-alias">Alias</label>
					<input id="page-alias" class="form-control" type="text" name="alias" value="{{ $page->alias }}" {{ $page->system == 1 ? 'disabled' : '' }}>
				</div>

				<div class="form-group">
					<label for="page-title">Title</label>
					<input id="page-title" class="form-control" type="text" name="title" value="{{ $page->title }}">
				</div>

				<div class="form-group">
					<label for="page-keywords">Keywords</label>
					<textarea id="page-keywords" class="form-control" name="keywords" rows="3">{{ $page->keywords }}</textarea>
				</div>

				<div class="form-group">
					<label for="page-description">Description</label>
					<textarea id="page-description" class="form-control" name="description" rows="3">{{ $page->description }}</textarea>
				</div>
			</div>

			@foreach ($setting_groups as $item)
				<div class="tab-pane" id="tab_setting_{{ $item->id }}">
					<h4>{{ $item->name }}</h4>
					@if ($item->description)
						<blockquote><small>{{ $item->description }}</small></blockquote>
					@endif

					<input type="hidden" name="setting_group[]" value="{{ $item->id }}">

					<a class="margin popup-ajax" href="{{ route('admin.settings.edit').'?group='.$item->id }}">Добавить настройку</a>
					<div id="settings-group-{{ $item->id }}">
						@include('admin::settings.items', ['settings' => $item->settings()->orderBy('order')->get()])
					</div>
				</div>
			@endforeach

			<script type="text/javascript"> $('.setting-items-list').sortable({handle: '.handle'}).disableSelection(); </script>
			<script type="text/javascript"> $('.setting-gal-list').sortable({handle: '.images_move'}).disableSelection(); </script>

			@foreach ($galleries as $item)
				<div class="tab-pane" id="tab_gallery_{{ $item->id }}">
					<h4>{{ $item->name }}</h4>
					@include('admin::gallery.items', ['gallery' => $item, 'items' => $item->items()->orderBy('order')->get()])
				</div>
			@endforeach

		</div>

		

		<div class="box-footer">
			<button type="submit" class="btn btn-primary">Сохранить</button>
		</div>
	</div>
</form>