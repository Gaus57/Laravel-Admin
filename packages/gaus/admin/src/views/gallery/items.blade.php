<div class="gallery-block">
	<label class="btn btn-success">Загрузить изображения
		<input type="file" name="images[]" value="" multiple style="display:none;" onchange="return galleryUpload(this, event)" data-url="{{ route('admin.gallery.imageUpload', [$gallery->id]) }}">
	</label>
	<hr>
	<div class="gallery-items">
		@foreach ($items as $item)
			@include('admin::gallery.item', ['item' => $item, 'gallery' => $gallery])
		@endforeach
	</div>
</div>