@extends('layouts.app')
@section('metaLabels')
    @parent
    @include('meta::manager', [
        'title' => __('Not Found'),
    ])
@stop
@section('title', __('Unauthorized'))
@section('code', '404')
@section('content')
    <div class="width flex bread">
        <ul class="bread-crumbs">
            <li><a href="/" target="_blank"><span>Главная</span></a></li>
            <li><span>404</span></li>
        </ul>
    </div>

    <h1 class="width titleH1">404</h1>

    <div class="dontPage flex">
        <div class="dontPage__title">404</div>
        <div class="dontPage__desc">К сожалению такой страницы не существует.</div>
    </div>
@endsection