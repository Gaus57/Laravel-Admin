@include('blocks.head')

<nav class="orange darken-2">
	<div class="nav-wrapper">
		<ul id="nav-mobile" class="left hide-on-med-and-down">
			<li><a href="{{ route('main') }}">Главная</a></li>
			@foreach ($main_menu as $item)
				<li><a href="{{ $item->url }}">{{ $item->name }}</a></li>
			@endforeach
		</ul>
	</div>
</nav>

@yield('content')

</body>
</html>