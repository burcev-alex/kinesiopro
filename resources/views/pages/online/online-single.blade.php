@extends('layouts.app')


@section('metaLabels')
    @parent
    @include('meta::manager', [
    'title' => $online->meta_title,
    'keywords' => $online->meta_keywords,
    "description" => $online->meta_description
    ])
@stop

@section('content')
    @include('includes.partials.breadcrumbs')
    <h1 class="width titleH1">{{ $online->title }}</h1>

    <main class="mainContent width flex">
        <div class="mainRight">
            <div class="mainBlock">
                <p> {{ $online->preview }} </p>
            </div>
        </div>
    </main>

@stop
