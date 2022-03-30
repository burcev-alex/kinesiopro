@extends('layouts.app')

@section('metaLabels')
    @parent
    @include('meta::manager', [
        'title' => 'KinesioPro | Официальные курсы Maitland, PNF, Bobath, CIMT, SEAS, Нейродинамика',
        'description' =>
            'Курсы физической реабилитации, мануальной терапии и лечебной физкультуры. Кинезио (кинезитерапия, кинезиотерапия, кинезотерапия)',
    ])
@stop

@push('before-styles')
    <link href="{{ mix('css/slick.css') }}" media="all" type="text/css" rel="stylesheet">
@endpush

@section('content')

    @include('includes.partials.breadcrumbs')

    <h1 class="width titleH1">{{ $course->name }}</h1>

    <!--Start mainContent-->
    <main class="mainContent width flex mainContent2">
        <div class="mainRight marafonRight">
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

            <a href="#" class="signUp flex">
                <span>Записаться</span>
            </a>
        </div>

        <aside class="aside flex aside2">
            <div class="signUpBlock">
                <ul class="signUpBlockList">
                    @if($course->start_date)
                    <li>
                        <div class="signUpBlockList__img">
                            <img src="/images/icon28.svg" alt="">
                        </div>

                        <div class="signUpBlockListRight">
                            <div class="signUpBlockListRight__title">Дата начала</div>
                            <div class="signUpBlockListRight__date">{{ $course->start_date->format('d F Y') }}</div>
                        </div>
                    </li>

                    <li>
                        <div class="signUpBlockList__img">
                            <img src="/images/icon29.svg" alt="">
                        </div>

                        <div class="signUpBlockListRight">
                            <div class="signUpBlockListRight__title">Продолжительность</div>
                            <div class="signUpBlockListRight__date">{{ $course->diff_day }} дня</div>
                        </div>
                    </li>
                    @endif

                    @if(strlen($course->format_display) > 0)
                    <li>
                        <div class="signUpBlockList__img">
                            <img src="/images/icon30.svg" alt="">
                        </div>

                        <div class="signUpBlockListRight">
                            <div class="signUpBlockListRight__title">Формат</div>
                            <div class="signUpBlockListRight__date">{{ $course->format_display }}</div>
                        </div>
                    </li>
                    @endif

                    @if(strlen($course->price) > 0)
                    <li>
                        <div class="signUpBlockList__img">
                            <img src="/images/icon31.svg" alt="">
                        </div>

                        <div class="signUpBlockListRight">
                            <div class="signUpBlockListRight__title">Стоимость</div>
                            <div class="signUpBlockListRight__date">{{ $course->price_format }} ₽</div>
                        </div>
                    </li>
                    @endif
                </ul>

                <a href="#" class="signUp flex">
                    <span>Записаться</span>
                </a>
            </div>
        </aside>
    </main>
    <!--End mainContent-->

    <!-- Start teachers -->
    @if($course->teachers->count() > 0)
    <section class="teachers">
        <div class="teachersIn width">
            <h2 class="teachersH2">Преподаватели</h2>

            <ul class="teachersList flex">
                @foreach ($course->teachers as $teacher)
                <li>
                    <img src="{{ $teacher->attachment->url }}" alt="{{ $teacher->full_name }}">

                    <div class="teachersListRight">
                        <span>{{ $teacher->full_name }}</span>
                        <p>{{ $teacher->description }}</p>
                    </div>
                </li>
                @endforeach
            </ul>
        </div>
    </section>
    @endif
    <!-- End teachers -->

@endsection

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
        mix('js/course_page_script.js')
    ],
    ])
@endpush