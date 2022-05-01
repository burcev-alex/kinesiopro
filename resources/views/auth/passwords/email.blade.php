@extends('layouts.app')

@section('metaLabels')
    @parent
    @includeIf('meta::manager', [
        'title' => 'Восстановление пароля',
        'description' => ''
    ])
@stop

@section('content')
    @include('includes.partials.breadcrumbs')
    <h1 class="width titleH1">Восстановление пароля</h1>

    <section class="formRegisterMain">
        <form action="{{ route('password.email') }}" data-action="async" method="POST" class="flex formAutorizaishen formRegisterRecover" id="passwordFogot">
            @csrf
            <div class="formRegisterBlock flex">
                <div class="formRegisterBlockItem">
                    <label for="email">Ваш e-mail <span>*</span></label>
                    <input type="text" id="email" name="email" value="{{ old('email') }}" required>
                </div>
            </div>

            <div class="formRegisterBtn flex">
                <button type="submit" class="flex enterBtn" value="Submit">
                    <span>Отправить</span>
                </button>
            </div>
        </form>
    </section>
@endsection
