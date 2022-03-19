@extends('layouts.app')

@section('metaLabels')
    @parent
    @include('meta::manager', [
    'title' => __('home.meta.title'),
    'description' => __('home.meta.description')
    ])
@stop

@section('content')
    @include('includes.header')
    <main>
        FIRST PAGE!
    </main>

@endsection
