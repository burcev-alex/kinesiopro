@extends('layouts.app')

@section('metaLabels')
    @parent
    @includeIf('meta::manager', [
        'title' => 'Сброс пароля',
        'description' => ''
    ])
@stop

@section('content')
    @include('includes.partials.breadcrumbs')
    <h1 class="width titleH1">Сброс пароля</h1>

    <section class="formRegisterMain">
        <form action="{{ route('password.update') }}" data-action="async" method="POST" class="flex formAutorizaishen" id="passwordReset">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}" />
            <div class="formRegisterBlock flex">
                <div class="formRegisterBlockItem">
                    <label for="email">E-mail <span>*</span></label>
                    <input type="text" id="email" name="email" value="{{ $request->email ?? old('email') }}" required>
                </div>
                <div class="formRegisterBlockItem">
                    <label for="password">Пароль <span>*</span></label>
                    <input type="password" id="password" name="password" value="" required>
                </div>
                <div class="formRegisterBlockItem">
                    <label for="password_confirmation">Повторить пароль <span>*</span></label>
                    <input type="password" id="password_confirmation" name="password_confirmation" value="" required>
                </div>
            </div>

            <div class="formRegisterBtn flex">
                <button type="submit" class="flex enterBtn" value="Submit">
                    <span>Сброса пароля</span>
                </button>
            </div>
        </form>
    </section>
@endsection
