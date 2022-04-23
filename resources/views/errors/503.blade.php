@extends('layouts.app')
@section('metaLabels')
    @parent
    @include('meta::manager', [
        'title' => __('Service Unavailable'),
    ])
@stop
@section('title', __('Service Unavailable'))
@section('code', '503')
@section('content')
    
    <div class="width flex bread">
        <ul class="bread-crumbs">
            <li><a href="/" target="_blank"><span>Главная</span></a></li>
            <li><span>503</span></li>
        </ul>
    </div>

    <h1 class="width titleH1">503</h1>

    <div class="dontPage flex">
        <div class="dontPage__title">503</div>
        <div class="dontPage__desc">Service Unavailable</div>
    </div>
@endsection