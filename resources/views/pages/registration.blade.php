@extends('layouts.app')
@section('content')
    <div class="registration-page">
        <div class="lk-heading">
            <p class="page-title">{{ __('auth.registration.title') }}</p>
        </div>
        <form id="registration_form" method="POST" class="register-form" action="{{ route('register.post') }}">
            <div class="register-form__row">
                <label>
                    <p>{{ __('auth.data.surname') }}</p>
                    <input type="text" name="surname" placeholder="{{ __('auth.data.surname_placeholder') }}">
                </label>
                <label>
                    <p>{{ __('auth.data.name') }}</p>
                    <input type="text" name="name" placeholder="{{ __('auth.data.name_placeholder') }}">
                </label>
            </div>

            <div class="register-form__row" placeholder="">
                <label>
                    <p>{{ __('auth.data.email') }}</p>
                    <input type="text" name="email" placeholder="mail@example.com">
                </label>
                <label>
                    <p>{{ __('auth.data.phone') }}</p>
                    <input type="text" class="phone-mask" name="phone" placeholder="+38">
                </label>
            </div>

            <div class="register-form__row">
                <label>
                    <p>{{ __('auth.data.password') }}</p>
                    <span class="eye">
                        <svg>
                            <use xlink:href="#eye_icn" />
                        </svg>
                    </span>
                    <input type="password" name="password" placeholder="{{ __('auth.data.password_placeholder') }}" id="password">
                </label>
                <label>
                    <p>{{ __('auth.data.new_password') }}</p>
                    <span class="eye">
                        <svg>
                            <use xlink:href="#eye_icn" />
                        </svg>
                    </span>
                    <input type="password" name="password_confirmation" placeholder="{{ __('auth.data.new_password_placeholder') }}">
                </label>
            </div>

            <button type="submit" class="sendFormBtn">{{ __('auth.registration.title') }}</button>
            <div class="social-block">
                <p>{{ __('auth.registration.social') }}</p>
                <div>
                    <a href="{{ route('socials.index','facebook') }}">
                        <svg>
                            <use xlink:href="#facebook_green-icn" />
                        </svg>
                    </a>
                    <a href="{{ route('socials.index','google') }}">
                        <svg>
                            <use xlink:href="#google_green-icn" />
                        </svg>
                    </a>
                </div>
            </div>
        </form>
    </div>
@endsection