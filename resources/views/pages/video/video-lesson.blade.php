@extends('layouts.app')


@section('metaLabels')
    @parent
    @include('meta::manager', [
    'title' => $stream->meta_title,
    "description" => $stream->meta_description
    ])
@stop

@section('content')
    @include('includes.partials.breadcrumbs')
    <h1 class="width titleH1">Видеокурсы</h1>

    @php
        $step = 0;
        $isFind = false;
        $next = $lesson;
        foreach($lessons as $key=>$item){
            if($item->id == $lesson->id){
                $step = $key;
                $isFind = true;
            }

            if($isFind && $next != $item){
                $next = $item;
                break;
            }
        }

        $step++;
    @endphp
    
    <!--Start videoCourse-->
    <section class="videoCourse width">
        <h2 class="videoCourse__title">Видеокурс: <span>«{{ $stream->title }}»</span></h2>

        <div class="videoCourseIn">
            <h3 class="videoCourseIn__title">Часть {{ $step }}. {{ $lesson->title }}</p>
            <div>{!! $lesson->description !!}</div>
            <div class="videoBottom flex">
                <div class="videoBottomLeft">
                    <span class="videoBottomLeft__lessons">{{ $step }} из {{ $lessons->count() }} уроков</span>
                    <b class="videoBottomLeft__bold">Доступен</b>
                </div>

                @if($next != $lesson)
                <div class="videoBottomRight">
                    <a href="{{ route('stream.single.lesson', ['stream' => $stream->slug, 'lessonId' => $next->id ]) }}">
                        <span>Следующий урок</span>
                    </a>
                    <span>Часть {{ ($step+1) }}. {{ $next->title }}</span>
                </div>
                @endif
            </div>

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
    </section>
    <!--End videoCourse-->
@stop

@push('after-scripts')
    @include('includes.scripts', [
    'list' => [
        mix('js/video_page_script.js')
    ],
    ])
@endpush
