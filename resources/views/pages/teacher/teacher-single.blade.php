@extends('layouts.app')


@section('metaLabels')
    @parent
    @include('meta::manager', [
    'title' => $teacher->meta_title,
    "description" => $teacher->meta_description
    ])
@stop

@section('content')
    @include('includes.partials.breadcrumbs')
    <h1 class="width titleH1">{{ $teacher->title }}</h1>
@stop