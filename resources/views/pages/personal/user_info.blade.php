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
            @include('includes.personal.sidebar', [
                'title' => 'Профиль',
            ])
        </div>

        <div class="accountMobil flex">
            <div class="accountCenter">
                <h3 class="accountCenter__title">Профиль</h3>

                @if ($user->picture)
                    <img src="{{ $user->picture->relativeUrl }}" width="150" alt="">
                @endif

                <form action="{{ route('profile.update') }}" data-action="async" method="POST" class="accountForm"
                    id="profileUpdate" style="display: none;">
                    <div class="accountFormBlock flex">
                        <label for="name">Имя</label>
                        <input type="text" id="name" value="{{ $user->firstname }}" required name="firstname">
                    </div>

                    <div class="accountFormBlock flex">
                        <label for="surname">Фамилия</label>
                        <input type="text" id="surname" value="{{ $user->surname }}" required name="surname">
                    </div>

                    <div class="accountFormBlock flex">
                        <label for="phone">Телефон</label>
                        <input type="text" id="phone" value="{{ $user->phone }}" required name="phone">
                    </div>

                    <div class="accountFormBlock flex">
                        <label for="email">E-mail</label>
                        <input type="text" id="email" value="{{ $user->email }}" required name="email">
                    </div>

                    <div class="accountFormBlock flex">
                        <label for="date">Дата рождения</label>
                        <input type="date" id="date" name="birthday" value="{{ $user->birthday }}">
                    </div>

                    <div class="accountFormBlock flex">
                        <label for="country">Страна</label>
                        <input type="text" id="country" value="{{ $user->country }}" required name="country">
                    </div>

                    <div class="accountFormBlock flex">
                        <label for="work">Местро работы</label>
                        <input type="text" id="work" name="work" value="{{ $user->work }}" required>
                    </div>

                    <div class="accountFormBlock flex">
                        <label for="jobs">Профессия</label>
                        <input type="text" id="jobs" name="position" required value="{{ $user->position }}">
                    </div>

                    <div class="accountFormBlock flex">
                        <label for="password">Пароль</label>
                        <input type="password" id="password" autocomplete="none" name="password">
                    </div>

                    <button type="submit" class="saveBtn flex">
                        <span>Сохранить</span>
                    </button>
                </form>

                <ul class="accountCenterList" id="accountInfoShow">
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
                        <span class="accountCenterList__two">{{ $user->work }}</span>
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
                        <a href="javascript:;" data-action="change-data-user">Изменить</a>
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
        </div>
    </section>
    <!-- End accountContent -->

@endsection

@push('after-scripts')
    @include('includes.scripts', [
        'list' => ['/js/profile_page_script.js'],
    ])
@endpush
