@extends('template')

@section('content')
	<div class="wraper w-1000">
	    <div class="row">
	    	<div class="col s3">
	    		<div class="collection">
	    			@foreach ($catalog_menu as $item)
	    				<a href="{{ $item->url }}" class="collection-item">{{ $item->name }}</a>
	    			@endforeach
	    		</div>
	    	</div>

	    	<div class="col s9">
	    		<div class="slider">
			    	<ul class="slides">
				    	@foreach ($slider as $item)
				    		@if ($item['link'])
				    			<li><a href="<?= $item['link'] ?>"><img src="<?= Settings::fileSrc($item['image']) ?>"></a></li>
				    		@else
				    			<li><img src="<?= Settings::fileSrc($item['image']) ?>"></li>
				    		@endif
				    	@endforeach
			    	</ul>
			    </div>
	    	</div>
	    </div>
    </div>
@stop