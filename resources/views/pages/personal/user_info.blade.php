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
                    <span class="accountCenterList__two">Константин</span>
                </li>

                <li>
                    <span class="accountCenterList__one">Фамилия</span>
                    <span class="accountCenterList__two">Контстантинопольский</span>
                </li>

                <li>
                    <span class="accountCenterList__one">Телефон</span>
                    <span class="accountCenterList__two">+7 925 775-54-36</span>
                </li>

                <li>
                    <span class="accountCenterList__one">E-mail</span>
                    <span class="accountCenterList__two">kostyan4@gmail.com</span>
                </li>

                <li>
                    <span class="accountCenterList__one">Дата рождения</span>
                    <span class="accountCenterList__two">30.10.1987</span>
                </li>

                <li>
                    <span class="accountCenterList__one">Страна</span>
                    <span class="accountCenterList__two">Российская федерация</span>
                </li>

                <li>
                    <span class="accountCenterList__one">Местро работы</span>
                    <span class="accountCenterList__two">Сбербанк России</span>
                </li>

                <li>
                    <span class="accountCenterList__one">Профессия</span>
                    <span class="accountCenterList__two">Менеджер</span>
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
                    <a href="#">Выйти</a>
                </li>
            </ul>
        </div>

        <div class="accountRight">
            <div class="signUpBlock">
                <ul class="signUpBlockList">
                    <li>
                        <div class="signUpBlockList__img">
                            <img src="/images/icon37.svg" alt="">
                        </div>

                        <div class="signUpBlockListRight">
                            <div class="signUpBlockListRight__title">Баналнс</div>
                            <div class="signUpBlockListRight__date">1500 руб.</div>
                        </div>
                    </li>

                    {{-- <li>
                        <div class="signUpBlockList__img">
                            <img src="/images/icon38.svg" alt="">
                        </div>

                        <div class="signUpBlockListRight">
                            <div class="signUpBlockListRight__title">Скидки</div>
                            <div class="signUpBlockListRight__date">15%</div>
                        </div>
                    </li>

                    <li>
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

            <div class="notifications">
                <div class="notifications__title">
                    <h3>Уведомления <span>3</span></h3>
                </div>

                <ul class="notificationsList">
                    <li>
                        <div class="notificationsList__day">Сегодня</div>
                        <div class="notificationsList__desc">Поясничный и грудной отделы</div>
                        <div class="notificationsList__name">Георгий Темичев</div>
                    </li>

                    <li>
                        <div class="notificationsList__day">Вчера</div>
                        <div class="notificationsList__desc">Поясничный и грудной отделы</div>
                        <div class="notificationsList__name">Георгий Темичев</div>
                    </li>

                    <li>
                        <div class="notificationsList__day">10 февраля</div>
                        <div class="notificationsList__desc">Поясничный и грудной отделы</div>
                        <div class="notificationsList__name">Георгий Темичев</div>
                    </li>
                </ul>
            </div>
        </div>
    </section>
    <!-- End accountContent -->
    
@endsection
