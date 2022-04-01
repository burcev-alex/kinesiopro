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

                <a href="#" class="signUp flex">
                    <span>Записаться</span>
                </a>
            </div>
        </aside>
    </main>
    <!--End mainContent-->

    <!-- Start teachers -->
    <section class="teachers registerPayContent">
        <div class="teachersIn">
            <h2 class="teachersH2">Регистрация на {{ $online->type_title}}</h2>
            <div class="payText">Стоимость: {{ $online->price }} рублей.</div>

            <form action="{{ route('checkout.save') }}" data-action="async" id="createOrder" method="POST" class="registerPay">
                @csrf
                <input type="hidden" name="order[user_id]" value="{{ $logged_in_user->id }}">

                <input type="hidden" name="product[id]" value="{{ $online->id }}">
                <input type="hidden" name="product[type]" value="{{ $online->type }}">
                <input type="hidden" name="product[name]" value="{{ $online->title }}">
                <input type="hidden" name="product[price]" value="{{ $online->price }}">
                <input type="hidden" name="product[qty]" value="1">

                <div class="registerBtnTop flex">
                    <div class="registerBtnTop__block">
                        <label for="name">Имя <span>*</span></label>
                        <input type="text" id="name" required name="order[name]">
                    </div>

                    <div class="registerBtnTop__block">
                        <label for="surname">Фамилия <span>*</span></label>
                        <input type="text" id="surname" required name="order[surname]">
                    </div>

                    <div class="registerBtnTop__block">
                        <label for="phone">Телефон <span>*</span></label>
                        <input type="text" id="phone" required name="order[phone]">
                    </div>
                </div>

                <div class="registerBtnBottom flex">
                    <div class="registerBtnTop__block">
                        <label for="email">E-mail <span>*</span></label>
                        <input type="text" id="email" required name="order[user_email]">
                    </div>

                    <div class="registerBtnTop__block">
                        <label for="promo">Промокод</label>
                        <input type="text" id="promo" name="order[promocode]">
                    </div>
                </div>

                <h3 class="registerPay__title">Платежный шлюз:</h3>
                <div class="registerPayBlock flex">
                    <div class="formIntensiveRadio">
                        <label class="blockCheckbox">
                            <span>Сбербанк (подходит для большинства платежей)</span>
                            <input type="radio" value="sberbank" checked="checked" name="order[payment]"><span class="checkmark"></span>
                        </label>
                        <img src="/images/icon41.svg" alt="">
                    </div>

                    <div class="formIntensiveRadio">
                        <label class="blockCheckbox">
                            <span>Robokassa (подходит для жителей Украины)</span>
                            <input type="radio" value="robokassa" name="order[payment]"><span class="checkmark"></span>
                        </label>

                        <img src="/images/icon41.svg" alt="">
                    </div>

                    <div class="formIntensiveRadio formIntensiveCheckbox">
                        <label class="blockCheckbox">
                            <span>Нажимая на кнопку «Зарегистрироваться», я принимаю условия <a href="{{ route('privacy_policy') }}" target="_blank">Согласие на
                                обработку персональных данных</a></span>
                            <input type="checkbox" required checked="checked" name="privacy_policy"><span class="checkmark"></span>
                        </label>
                    </div>


                    <div class="formIntensiveRadio formIntensiveCheckbox">
                        <label class="blockCheckbox">
                            <span>Нажимая на кнопку «Зарегистрироваться», я принимаю условия <a href="{{ route('public_offer') }}" target="_blank">Договора-оферты</a></span>
                            <input type="checkbox" required name="public_offer"><span class="checkmark"></span>
                        </label>
                    </div>
                </div>

                <button type="submit" class="flex registerPaySend">
                    <span>Зарегистрироваться</span>
                </button>

                <div class="errors"></div>

                <div class="payText">После покупки с Вами свяжется наш менеджер</div>
            </form>
        </div>
    </section>
    <!-- End teachers -->

@stop

@push('after-scripts')
    @include('includes.scripts', [
    'list' => [
        mix('js/online_page_script.js')
    ],
    ])
@endpush
