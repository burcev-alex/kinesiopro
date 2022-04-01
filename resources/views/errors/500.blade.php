@extends('layouts.error')
@section('metaLabels')
    @parent
    @include('meta::manager', [
        'title' => __('Not Found'),
    ])
@stop
@section('title', __('Server Error'))
@section('code', '500')
@section('content')
    
    <div class="width flex bread">
        <ul class="bread-crumbs">
            <li><a href="/" target="_blank"><span>Главная</span></a></li>
            <li><span>500</span></li>
        </ul>
    </div>

    <h1 class="width titleH1">500</h1>

    <div class="dontPage flex">
        <div class="dontPage__title">500</div>
        <div class="dontPage__desc">Server Error</div>
    </div>
@endsection