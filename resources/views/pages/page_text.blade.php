@extends('template')

@section('content')
    <h1 class="header">{{ $page->name }}</h1>
    <div>{!! $page->text !!}</div>
@stop