@extends('layouts.app')


@section('metaLabels')
    @parent
    @include('meta::manager', [
    'title' => $news_paper->meta_title,
    'keywords' => $news_paper->meta_keywords,
    "description" => $news_paper->meta_description
    ])
@stop

@section('content')
    @include('includes.partials.breadcrumbs')
    <h1 class="width titleH1">{{ $news_paper->title }}</h1>

    <main class="mainContent width flex">
        <div class="mainRight">
        @foreach ($components as $key=>$component)
            <div class="mainBlock" id="anchor{{ $key }}">
            @switch($component->slug)
                @case('image')
                    <x-news.image :number="$key" :fields="$component->mediaFields" />
                @break
                @case('title-text')
                    <x-news.title-text :number="$key" :fields="$component->mediaFields" />
                @break
                @case('lists')
                    <x-news.lists :number="$key" :fields="$component->mediaFields" />
                @break
                @case('video')
                    <x-news.video :number="$key" :fields="$component->mediaFields" />
                @break
                @case('text-citation')
                    <x-news.text-citation :number="$key" :fields="$component->mediaFields" />
                @break
                @case('gif')
                    <x-news.gif :number="$key" :fields="$component->mediaFields" />
                @break
                @case('text')
                    <x-news.text :number="$key" :fields="$component->mediaFields" />
                @break
                @default

            @endswitch
            </div>
        @endforeach
        </div>

        <aside class="aside flex">
            <img src="{{ $news_paper->banner != null ? $news_paper->banner->url() : '' }}" alt="">
            <div>{{ $news_paper->title }}</div>
        </aside>
    </main>

@stop
