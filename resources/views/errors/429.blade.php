@extends('layouts.app')
@section('metaLabels')
    @parent
    @include('meta::manager', [
        'title' => __('Too Many Requests'),
    ])
@stop
@section('title', __('Too Many Requests'))
@section('code', '429')
@section('content')

    <div class="width flex bread">
        <ul class="bread-crumbs">
            <li><a href="/" target="_blank"><span>Главная</span></a></li>
            <li><span>429</span></li>
        </ul>
    </div>

    <h1 class="width titleH1">429</h1>

    <div class="dontPage flex">
        <div class="dontPage__title">429</div>
        <div class="dontPage__desc">Too Many Requests</div>
    </div>
@endsection