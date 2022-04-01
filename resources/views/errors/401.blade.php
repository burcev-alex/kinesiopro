@extends('layouts.app')
@section('metaLabels')
    @parent
    @include('meta::manager', [
        'title' => __('Forbidden'),
    ])
@stop
@section('title', __('Forbidden'))
@section('code', '401')
@section('content')
    <div class="width flex bread">
        <ul class="bread-crumbs">
            <li><a href="/" target="_blank"><span>Главная</span></a></li>
            <li><span>401</span></li>
        </ul>
    </div>

    <h1 class="width titleH1">401</h1>

    <div class="dontPage flex">
        <div class="dontPage__title">401</div>
        <div class="dontPage__desc">Доступ запрещен</div>
    </div>
@endsection