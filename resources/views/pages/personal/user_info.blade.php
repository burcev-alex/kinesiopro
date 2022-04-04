@extends('layouts.app')

@section('metaLabels')
    @parent
    @include('meta::manager', [
        'title' => __('breadcrumbs.personal.profile'),
    ])
@stop

@section('content')
    @include('includes.partials.breadcrumbs')
    
    <h1 class="width titleH1">Личный кабинет</h1>

    <!-- Start accountContent -->
    <section class="accountContent width flex">
        <div class="accountLeft">
            @include('includes.personal.sidebar')
        </div>

        <div class="accountCenter">
            <h3 class="accountCenter__title">Профиль</h3>

            <img src="/images/img23.png" alt="">

            <ul class="accountCenterList">
                <li>
                    <span class="accountCenterList__one">Имя</span>
                    <span class="accountCenterList__two">{{ $user->firstname }}</span>
                </li>

                <li>
                    <span class="accountCenterList__one">Фамилия</span>
                    <span class="accountCenterList__two">{{ $user->surname }}</span>
                </li>

                <li>
                    <span class="accountCenterList__one">Телефон</span>
                    <span class="accountCenterList__two">{{ $user->phone }}</span>
                </li>

                <li>
                    <span class="accountCenterList__one">E-mail</span>
                    <span class="accountCenterList__two">{{ $user->email }}</span>
                </li>

                <li>
                    <span class="accountCenterList__one">Дата рождения</span>
                    <span class="accountCenterList__two">{{ $user->birthday }}</span>
                </li>

                <li>
                    <span class="accountCenterList__one">Страна</span>
                    <span class="accountCenterList__two">{{ $user->country }}</span>
                </li>

                <li>
                    <span class="accountCenterList__one">Местро работы</span>
                    <span class="accountCenterList__two">{{ $user->place }}</span>
                </li>

                <li>
                    <span class="accountCenterList__one">Профессия</span>
                    <span class="accountCenterList__two">{{ $user->position }}</span>
                </li>

                <li>
                    <span class="accountCenterList__one">Пароль</span>
                    <span class="accountCenterList__two">************</span>
                </li>
            </ul>

            <ul class="accountCenterRed flex">
                <li>
                    <a href="#">Изменить</a>
                </li>

                <li>
                    <a href="{{ route('logout') }}">Выйти</a>
                </li>
            </ul>
        </div>

        <div class="accountRight">
            <div class="signUpBlock">
                <ul class="signUpBlockList">
                    {{-- <li>
                        <div class="signUpBlockList__img">
                            <img src="/images/icon37.svg" alt="">
                        </div>

                        <div class="signUpBlockListRight">
                            <div class="signUpBlockListRight__title">Баланс</div>
                            <div class="signUpBlockListRight__date">1500 руб.</div>
                        </div>
                    </li> --}}

                    <li>
                        <div class="signUpBlockList__img">
                            <img src="/images/icon38.svg" alt="">
                        </div>

                        <div class="signUpBlockListRight">
                            <div class="signUpBlockListRight__title">
                                <a href="{{ route('discount') }}">Скидки</a>
                            </div>
                            <div class="signUpBlockListRight__date">0%</div>
                        </div>
                    </li>

                    {{-- <li>
                        <div class="signUpBlockList__img">
                            <img src="/images/icon39.svg" alt="">
                        </div>

                        <div class="signUpBlockListRight">
                            <div class="signUpBlockListRight__title">Бонусы</div>
                            <div class="signUpBlockListRight__date">150 бонусов</div>
                        </div>
                    </li> --}}
                </ul>
            </div>

            @include('includes.personal.notification')
            
        </div>
    </section>
    <!-- End accountContent -->
    
@endsection

@push('after-scripts')
    @include('includes.scripts', [
    'list' => [
        '/js/profile_page_script.js'
    ],
    ])
@endpush