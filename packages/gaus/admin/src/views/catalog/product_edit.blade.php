@section('page_name')
	<h1>Каталог
		<small>{{ $product->id ? 'Редактировать товар' : 'Новый товар' }}</small>
	</h1>
@stop

<form action="{{ route('admin.catalog.productSave') }}" onsubmit="return productSave(this, event)">
	<input type="hidden" name="id" value="{{ $product->id }}">

	<div class="nav-tabs-custom">
		<ul class="nav nav-tabs">
			<li class="active"><a href="#tab_1" data-toggle="tab">Параметры</a></li>
			<li><a href="#tab_2" data-toggle="tab">Текст</a></li>
			<li><a href="#tab_4" data-toggle="tab">Изображения</a></li>
			<li><a href="#tab_3" data-toggle="tab">SEO</a></li>
			<li class="pull-right">
				<a href="{{ route('admin.catalog.products', [$product->catalog_id]) }}" onclick="return catalogContent(this)">К списку товаров</a>
			</li>
		</ul>
		<div class="tab-content">
			<div class="tab-pane active" id="tab_1">
				
				<div class="form-group">
					<label for="product-name">Название</label>
					<input id="product-name" class="form-control" type="text" name="name" value="{{ $product->name }}">
				</div>

				<div class="form-group" style="width:400px;">
					<label for="product-catalog">Каталог</label>
					<select id="product-catalog" class="form-control" name="catalog_id">
						@foreach ($catalogs as $item)
							<option value="{{ $item->id }}" {{ $product->catalog_id == $item->id ? 'selected' : '' }}>{{ $item->name }}</option>
						@endforeach
					</select>
				</div>

				<div class="form-group" style="width:200px;">
					<label for="product-price">Цена</label>
					<input id="product-price" class="form-control" type="text" name="price" value="{{ $product->price }}">
				</div>

				<div class="row">
					<div class="col-md-2">
						<div class="form-group">
							<label for="product-price_unit">Цена за ед.</label>
							<input id="product-price_unit" class="form-control" type="text" name="price_unit" value="{{ $product->price_unit }}">
						</div>
					</div>
					<div class="col-md-2">
						<div class="form-group">
							<label for="product-unit">еденица</label>
							<input id="product-unit" class="form-control" type="text" name="unit" value="{{ $product->unit }}">
						</div>
					</div>
				</div>

				<div class="form-group">
					<label>
						<input type="checkbox" class="minimal" name="on_main" value="1" {{ $product->on_main == 1 ? 'checked' : '' }}>
						Показывать на главной
					</label>
				</div>

				<div class="form-group">
					<label>
						<input type="checkbox" class="minimal" name="published" value="1" {{ $product->published == 1 ? 'checked' : '' }}>
						Показывать товар
					</label>
				</div>

				
			</div>

			<div class="tab-pane" id="tab_2">
				<div class="form-group">
					<textarea id="editorp1" name="text" rows="10" cols="80">{{ $product->text }}</textarea>
					<script type="text/javascript">startCkeditor('editorp1');</script>
				</div>
			</div>

			<div class="tab-pane" id="tab_4">
				<input id="product-image" type="hidden" name="image" value="{{ $product->image }}">
				@if ($product->id)
					<div class="form-group">
						<label class="btn btn-success">
							<input id="offer_imag_upload" type="file" multiple data-url="{{ route('admin.catalog.productImageUpload', $product->id) }}" style="display:none;" onchange="productImageUpload(this, event)">
							Загрузить изображения
						</label>
					</div>

					<div class="images_list">
						@foreach ($product->images()->orderBy('order')->get() as $image)
							@include('admin::catalog.product_image', ['image' => $image, 'active' => $product->image])
						@endforeach
					</div>
				@else
					<p class="text-yellow">Изображения можно будет загрузить после сохранения товара!</p>
				@endif
			</div>

			<div class="tab-pane" id="tab_3">
				<div class="form-group">
					<label for="product-alias">Alias</label>
					<input id="product-alias" class="form-control" type="text" name="alias" value="{{ $product->alias }}">
				</div>

				<div class="form-group">
					<label for="product-title">Title</label>
					<input id="product-title" class="form-control" type="text" name="title" value="{{ $product->title }}">
				</div>

				<div class="form-group">
					<label for="product-keywords">Keywords</label>
					<textarea id="product-keywords" class="form-control" name="keywords" rows="3">{{ $product->keywords }}</textarea>
				</div>

				<div class="form-group">
					<label for="product-description">Description</label>
					<textarea id="product-description" class="form-control" name="description" rows="3">{{ $product->description }}</textarea>
				</div>
			</div>
		</div>

		<div class="box-footer">
			<button type="submit" class="btn btn-primary">Сохранить</button>
		</div>
	</div>
</form>