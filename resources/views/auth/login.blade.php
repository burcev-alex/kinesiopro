@extends('layouts.app')

@section('metaLabels')
    @parent
    @includeIf('meta::manager', [
        'title' => 'Авторизация',
        'description' => ''
    ])
@stop

@section('content')

    @include('includes.partials.breadcrumbs')

    <h1 class="width titleH1">Авторизация</h1>

    <!--Start auth-->
    <section class="formRegisterMain">
        <form action="{{ route('login.store') }}" data-action="async" method="POST" class="flex formAutorizaishen" id="autorization">
            @csrf
            <div class="formRegisterBlock flex">
                <div class="formRegisterBlockItem">
                    <label for="email">E-mail <span>*</span></label>
                    <input type="text" id="email" name="email" value="{{ old('email') }}">
                    <a href="{{ route('password.create') }}" class="forgotPassword"><span>Забыли пароль?</span></a>
                </div>

                <div class="formRegisterBlockItem">
                    <label for="password">Пароль <span>*</span></label>
                    <input type="password" id="password" name="password">
                    <a href="{{ route('register.create') }}" class="text-right"><span>Регистрация</span></a>
                </div>
            </div>

            <div class="formRegisterBtn flex">
                <button type="submit" class="flex enterBtn" value="Submit">
                    <span>Войти</span>
                </button>
            </div>
        </form>
    </section>
    <!--End auth-->

    @mobile
    <div class="push"></div>
    @endmobile

    @tablet
    <div class="push"></div>
    @endtablet
@endsection

@section('footer_class_custom') fix @endsection