@extends('layouts.app')

@section('title', __('Reset Password'))

@section('content')
    @include('includes.partials.breadcrumbs')
    <h1 class="width titleH1">Восстановение пароля</h1>

    <section class="formRegisterMain">
        <form action="{{ route('password.email') }}" data-action="async" method="POST" class="flex formAutorizaishen" id="passwordFogot">
            @csrf
            <div class="formRegisterBlock flex">
                <div class="formRegisterBlockItem">
                    <label for="email">E-mail <span>*</span></label>
                    <input type="text" id="email" name="email" value="{{ old('email') }}" required>
                </div>
            </div>

            <div class="formRegisterBtn flex">
                <button type="submit" class="flex enterBtn" value="Submit">
                    <span>Отправить ссылку для сброса пароля</span>
                </button>
            </div>
        </form>
    </section>
@endsection
