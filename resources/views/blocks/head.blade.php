<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>{{ $head_title or '' }}</title>
	<meta name="keywords" content="{{ $head_keywords or '' }}">
	<meta name="description" content="{{ $head_description or '' }}">
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<link href="/materialize/css/materialize.min.css" rel="stylesheet">
	<link href="/css/main.css" rel="stylesheet">

	<script src="https://code.jquery.com/jquery-2.2.3.min.js"></script>
	<script src="/materialize/js/materialize.min.js"></script>
	<script src="/js/main.js"></script>
</head>
<body>