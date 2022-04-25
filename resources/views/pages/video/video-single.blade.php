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
    
    <!--Start videoCourse-->
    <section class="videoCourse width">
        <h2 class="videoCourse__title">Видеокурс: <span>«{{ $stream->title }}»</span></h2>
        
        <div class="videoCourseContent">
            @foreach ($lessons as $lesson)
                <div class="videoCourseItem flex">
                    <img src="/images/icon46.svg" alt="{{ $lesson->title }}">

                    <div class="videoCourseItemRight">
                        <a href="{{ route('stream.single.lesson', ['stream' => $stream->slug, 'lessonId' => $lesson->id ]) }}">Часть {{ ($loop->index+1) }}. {{ $lesson->title }}</a>
                        <p>{{ $lesson->description }}</p>
                    </div>
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
