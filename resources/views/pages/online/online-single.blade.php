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
        </div>

        <aside class="aside flex aside2">
            <div class="signUpBlock">
                <ul class="signUpBlockList">
                    @if($online->start_date)
                    <li>
                        <div class="signUpBlockList__img">
                            <img src="/images/icon28.svg" alt="">
                        </div>

                        <div class="signUpBlockListRight">
                            <div class="signUpBlockListRight__title">Дата начала</div>
                            <div class="signUpBlockListRight__date">{{ $online->start_date_format }}</div>
                        </div>
                    </li>
                    @endif

                    @if($online->diff_day)
                    <li>
                        <div class="signUpBlockList__img">
                            <img src="/images/icon29.svg" alt="">
                        </div>

                        <div class="signUpBlockListRight">
                            <div class="signUpBlockListRight__title">Продолжительность</div>
                            <div class="signUpBlockListRight__date">{{ $online->diff_day }} {{trans_choice('день|дня|дней', $online->diff_day)}}</div>
                        </div>
                    </li>
                    @endif

                    @if(strlen($online->price) > 0)
                    <li>
                        <div class="signUpBlockList__img">
                            <img src="/images/icon31.svg" alt="">
                        </div>

                        <div class="signUpBlockListRight">
                            <div class="signUpBlockListRight__title">Стоимость</div>
                            <div class="signUpBlockListRight__date">{{ $online->price_format }} ₽</div>
                        </div>
                    </li>
                    @endif
                </ul>

                <a href="#checkout" class="signUp flex">
                    <span>Записаться</span>
                </a>
            </div>
        </aside>
    </main>
    <!--End mainContent-->

    <!-- Start teachers -->
    <section class="teachers registerPayContent" id="checkout">
        <div class="teachersIn">
            <h2 class="teachersH2">Регистрация на {{ $online->type_title}}</h2>
            <div class="payText">Стоимость: {{ $online->price }} рублей.</div>

            @include('includes.personal.checkout', [
                'type' => 'online',
                'entity' => $online
            ])
        </div>
    </section>
    <!-- End teachers -->

@stop

@push('after-scripts')
    @include('includes.scripts', [
    'list' => [
        mix('js/plugins/mask.js'),
        mix('js/online_page_script.js')
    ],
    ])
@endpush
