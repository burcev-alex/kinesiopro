@extends('layouts.app')
@section('metaLabels')
    @parent
    @include('meta::manager', [
    'title' => __('auth.registration.title'),
    'keywords' => "",
    'description' => ""
    ])
@stop

@section('content')
    @include('includes.partials.breadcrumbs')
    <h1 class="width titleH1">{{ __('auth.registration.title') }}</h1>  

    <!--Start schedule-->
    <section class="formRegisterMain">
        <div class="scheduleContent">
            <div class="scheduleTop">
                <ul class="scheduleList flex">
                    <li>
                        <a href="#" class="active">Регистрация</a>
                    </li>

                    <li>
                        <div class="scheduleSlider">
                            <span class="scheduleSlider__btn"></span>
                        </div>
                    </li>

                    <li>
                        <a href="#">Вход с помощью соцсетей</a>
                    </li>
                </ul>
            </div>
        </div>

        <form id="registrationStaticForm" action="{{ route('register.post') }}" method="POST" class="flex formRegister">
            @csrf
            <div class="formRegisterBlock">
                <div class="formRegisterBlockItem">
                    <label for="name">{{ __('auth.data.firstname') }} <span>*</span></label>
                    <input type="text" id="firstname" name="firstname" required>
                </div>

                <div class="formRegisterBlockFile formRegisterBlockFileMobil">
                    <input type="file" name="avatar">
                    <span>Добавить фото</span>
                </div>

                <div class="formRegisterBlockSelects selectCountryMobil">
                    <label for="country">Страна <span>*</span></label>

                    <select class="select selectCountry" name="country" id="country">
                        <option value="Россия">Россия</option>
                        <option value="Беларусь">Беларусь</option>
                        <option value="Казахстан">Казахстан</option>
                        <option value="Грузия">Грузия</option>
                    </select>
                </div>

                <div class="formRegisterBlockItem formRegisterBlockItemPassword2">
                    <label for="password">{{ __('auth.data.password') }}</label>
                    <input type="password" id="password"  name="password">
                </div>
            </div>

            <div class="formRegisterBlock">
                <div class="formRegisterBlockItem formRegisterBlockItemSurnam">
                    <label for="surname">{{ __('auth.data.surname') }} <span>*</span></label>
                    <input type="text" id="surname" name="surname" required>
                </div>

                <div class="formRegisterBlockItem formRegisterBlockItemEmail">
                    <label for="email">E-mail <span>*</span></label>
                    <input type="text" id="email" name="email" required>
                </div>

                <div class="formRegisterBlockItem formRegisterBlockItemWork">
                    <label for="work">Место работы <span>*</span></label>
                    <input type="text" id="work" name="work" required>
                </div>

                <div class="formRegisterBlockItem formRegisterBlockItemPassword">
                    <label for="password2">{{ __('auth.data.new_password') }} <span>*</span></label>
                    <input type="password" id="password2" name="password_confirmation">
                </div>
            </div>

            <div class="formRegisterBlock">
                <div class="formRegisterBlockItem formRegisterBlockItemMobil">
                    <label for="phone">Телефон <span>*</span></label>
                    <input type="text" id="phone" name="phone" required>
                </div>

                <div class="birthday flex birthdayMobil">
                    <label for="birthday">Дата рождения</label>
                    <select class="select birthdaySelect" id="birthday" name="birthday_day">
                        <option value="день">день</option>
                        @for($i=1; $i<=31; $i++)
                        <option value="{{ ($i<10)?'0':'' }}{{ $i }}">{{ ($i<10)?'0':'' }}{{ $i }}</option>
                        @endfor
                    </select>

                    <select class="select birthdaySelect" name="month" id="birthday_month">
                        <option value="день">месяц</option>
                        <option value="Январь">Январь</option>
                        <option value="Февраль">Февраль</option>
                        <option value="Март">Март</option>
                        <option value="Апрель">Апрель</option>
                        <option value="Май">Май</option>
                        <option value="Июнь">Июнь</option>
                        <option value="Июль">Июль</option>
                        <option value="Август">Август</option>
                        <option value="Сентябрь">Сентябрь</option>
                        <option value="Октябрь">Октябрь</option>
                        <option value="Ноябрь">Ноябрь</option>
                        <option value="Декабрь">Декабрь</option>
                    </select>

                    <select class="select birthdaySelect" id="year" name="birthday_year">
                        <option value="год">год</option>
                        @for($i=2004; $i>=1950; $i--)
                        <option value="{{ $i }}">{{ $i }}</option>
                        @endfor
                    </select>

                    <img src="/images/icon36.svg" alt="">
                </div>

                <div class="formRegisterBlockSelects formRegisterBlockSelects2 formRegisterBlockSelectsMobil">
                    <label for="profesional">Профессия <span>*</span></label>

                    <select class="select selectCountry" id="profesional" name="position">
                        <option value="Травматолог">Травматолог</option>
                        <option value="Ортопед">Ортопед</option>
                        <option value="Реабилитолог">Реабилитолог</option>
                    </select>
                </div>
            </div>

            <p class="formRegister__desc">*В сертификате будут указаны данные, которые были указаны при регистрации</p>

            <div class="formRegisterBtn flex">
                <div class="formRegisterBlockFile scanPassword flex">
                    <input type="file" name="scan">
                    <span>Прикрепить скан паспорта</span>
                </div>

                <button type="submit" class="flex registerBtn sendFormBtn">
                    <span>{{ __('auth.registration.submit') }}</span>
                </button>
            </div>
        </form>
    </section>
    <!--End schedule-->
@endsection