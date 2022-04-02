@extends('layouts.app')
@section('metaLabels')
    @parent
    @include('meta::manager', [
        'title' => __('Page Expired'),
    ])
@stop
@section('title', __('Page Expired'))
@section('code', '419')
@section('content')
    
    <div class="width flex bread">
        <ul class="bread-crumbs">
            <li><a href="/" target="_blank"><span>Главная</span></a></li>
            <li><span>419</span></li>
        </ul>
    </div>

    <h1 class="width titleH1">419</h1>

    <div class="dontPage flex">
        <div class="dontPage__title">419</div>
        <div class="dontPage__desc">Доступ запрещен</div>
    </div>
@endsection
