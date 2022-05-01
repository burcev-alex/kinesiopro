@extends('layouts.app')


@section('metaLabels')
    @parent
    @include('meta::manager', [
        'title' => $teacher->meta_title,
        'description' => $teacher->meta_description,
    ])
@stop

@push('before-styles')
    <link href="{{ mix('css/slick.css') }}" media="all" type="text/css" rel="stylesheet">
@endpush

@section('content')
    @include('includes.partials.breadcrumbs')
    <h1 class="width titleH1">Преподаватели</h1>

    <section class="teachersArticle flex width">
        <div class="teachersArticleLeft">
            <div class="teachersArticleLeft__name">{{ $teacher->full_name }}</div>

            <img src="{{ $teacher->attachment_webp }}" alt="{{ $teacher->full_name }}">

            <ul class="teachersSocial flex">
                @if($teacher->vk)
                <li>
                    <a href="{{ $teacher->vk }}" target="_blank">
                        <img src="/images/icon6.svg" alt="{{ $teacher->full_name }}">
                    </a>
                </li>
                @endif
                @if($teacher->youtube)
                <li>
                    <a href="{{ $teacher->youtube }}" target="_blank">
                        <img src="/images/icon8.svg" alt="{{ $teacher->full_name }}">
                    </a>
                </li>
                @endif
            </ul>
        </div>

        <div class="teachersArticleRight">
            <div>{!! $teacher->description !!}</div>

            <br>
            <p>Образование:</p>
            <div>{!! $teacher->education !!}</div>

            <br>
            <p>Курсы и сертификаты:</p>
            <div>{!! $teacher->certificates !!}</div>

            <br>
            <p>Специализация:</p>
            <div>{!! $teacher->specialization !!}</div>
        </div>
    </section>

    <script language="JavaScript">
        window.filterParams = {
            teacher: '{{$teacher->id}}'
        };
    </script>
    @include('includes.home.schedule', [
        'title' => $teacher->full_name.'. Расписание семенаров',
        'fieldsFilter' => [
            'city' => true,
            'format' => true,
            'teacher' => false,
            'period' => true,
            'direct' => true,
        ]
    ])
@stop

@push('before-scripts')
    @include('includes.scripts', [
    'list' => [
        mix('js/plugins/slick.js')
    ],
    ])
@endpush

@push('after-scripts')
    @include('includes.scripts', [
    'list' => [
        mix('js/teacher_page_script.js')
    ],
    ])
@endpush