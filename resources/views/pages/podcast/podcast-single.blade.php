@extends('layouts.app')


@section('metaLabels')
    @parent
    @include('meta::manager', [
    'title' => $podcast->meta_title,
    'keywords' => $podcast->meta_keywords,
    "description" => $podcast->meta_description
    ])
@stop

@section('content')
    @include('includes.partials.breadcrumbs')
    <h1 class="width titleH1">{{ $podcast->title }}</h1>

    <main class="mainContent width flex">
        <div class="mainRight">
            <div class="mainBlock">
                <p> {{ $podcast->description }} </p>
            </div>
        </div>
    </main>

@stop
