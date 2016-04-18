@section('page_name')
	<h1>Каталог
		<small>{{ $catalog->id ? 'Редактировать раздел' : 'Новый раздел' }}</small>
	</h1>
@stop

<form action="{{ route('admin.catalog.catalogSave') }}" onsubmit="return catalogSave(this, event)">
	<input type="hidden" name="id" value="{{ $catalog->id }}">

	<div class="nav-tabs-custom">
		<ul class="nav nav-tabs">
			<li class="active"><a href="#tab_1" data-toggle="tab">Параметры</a></li>
			<li><a href="#tab_2" data-toggle="tab">Текст</a></li>
			<li><a href="#tab_3" data-toggle="tab">SEO</a></li>
		</ul>
		<div class="tab-content">
			<div class="tab-pane active" id="tab_1">
				
				<div class="form-group">
					<label for="catalog-name">Название</label>
					<input id="catalog-name" class="form-control" type="text" name="name" value="{{ $catalog->name }}">
				</div>

				<div class="form-group" style="width:400px;">
					<label for="catalog-parent">Родительский раздел</label>
					<select id="catalog-parent" class="form-control" name="parent_id">
						<option value="0">--корень--</option>
						@foreach ($catalogs as $item)
							@if ($item->id != $catalog->id)
								<option value="{{ $item->id }}" {{ $catalog->parent_id == $item->id ? 'selected' : '' }}>{{ $item->name }}</option>
							@endif
						@endforeach
					</select>
				</div>

				<div class="form-group">
					<label>
						<input type="checkbox" class="minimal" name="on_main" value="1" {{ $catalog->on_main == 1 ? 'checked' : '' }}>
						Показывать на главной
					</label>
				</div>

				<div class="form-group">
					<label>
						<input type="checkbox" class="minimal" name="published" value="1" {{ $catalog->published == 1 ? 'checked' : '' }}>
						Показывать раздел
					</label>
				</div>

				
			</div>

			<div class="tab-pane" id="tab_2">
				<div class="form-group">
					<label>Текст перед товарами</label>
					<textarea id="editor1" name="text_prev" rows="10" cols="80">{{ $catalog->text_prev }}</textarea>
					<script type="text/javascript">startCkeditor('editor1');</script>
				</div>

				<div class="form-group">
					<label>Текст после товаров</label>
					<textarea id="editor2" name="text_after" rows="10" cols="80">{{ $catalog->text_after }}</textarea>
					<script type="text/javascript">startCkeditor('editor2');</script>
				</div>
			</div>

			<div class="tab-pane" id="tab_3">
				<div class="form-group">
					<label for="catalog-alias">Alias</label>
					<input id="catalog-alias" class="form-control" type="text" name="alias" value="{{ $catalog->alias }}">
				</div>

				<div class="form-group">
					<label for="catalog-title">Title</label>
					<input id="catalog-title" class="form-control" type="text" name="title" value="{{ $catalog->title }}">
				</div>

				<div class="form-group">
					<label for="catalog-keywords">Keywords</label>
					<textarea id="catalog-keywords" class="form-control" name="keywords" rows="3">{{ $catalog->keywords }}</textarea>
				</div>

				<div class="form-group">
					<label for="catalog-description">Description</label>
					<textarea id="catalog-description" class="form-control" name="description" rows="3">{{ $catalog->description }}</textarea>
				</div>
			</div>
		</div>

		<div class="box-footer">
			<button type="submit" class="btn btn-primary">Сохранить</button>
		</div>
	</div>
</form>