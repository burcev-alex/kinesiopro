<?php

namespace App\Providers;

use Illuminate\Support\Facades\Lang;
use Illuminate\Support\ServiceProvider;
use Tabuna\Breadcrumbs\Breadcrumbs;
use Tabuna\Breadcrumbs\Trail;

class BreadcrumbsServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Регистрация
        Breadcrumbs::for(
            'register.create',
            fn (Trail $trail) =>
            $trail->push(Lang::get('breadcrumbs.register'), route('register.create'))
        );

        // Блог
        Breadcrumbs::for(
            'blog',
            fn (Trail $trail) =>
            $trail->push(Lang::get('breadcrumbs.blog'), route('blog'))
        );

        // Тесты
        Breadcrumbs::for(
            'tests',
            fn (Trail $trail) =>
            $trail->push(Lang::get('breadcrumbs.tests'), route('tests'))
        );

        // Контакты
        Breadcrumbs::for(
            'contacts',
            fn (Trail $trail) =>
            $trail->push(Lang::get('breadcrumbs.contacts'), route('contacts'))
        );

        // Подкасты
        Breadcrumbs::for(
            'podcast',
            fn (Trail $trail) =>
            $trail->push(Lang::get('breadcrumbs.podcast'), route('podcast'))
        );

        // Мои данные
        Breadcrumbs::for(
            'profile.index',
            fn (Trail $trail) =>
            $trail->push(Lang::get('breadcrumbs.personal.profile'), route('profile.index'))
        );

        // Уведомления
        Breadcrumbs::for(
            'profile.notifications',
            fn (Trail $trail) =>
            $trail->push(Lang::get('breadcrumbs.personal.profile'), route('profile.index'))->push(Lang::get('breadcrumbs.personal.notifications'), route('profile.notifications'))
        );

        // правила конфиденциальности
        Breadcrumbs::for(
            'privacy_policy',
            fn (Trail $trail) =>
            $trail->push(Lang::get('breadcrumbs.policy'), route('privacy_policy'))
        );

        // публичная оферта
        Breadcrumbs::for(
            'public_offer',
            fn (Trail $trail) =>
            $trail->push(Lang::get('breadcrumbs.public_offer'), route('public_offer'))
        );

        // О компании
        Breadcrumbs::for(
            'contacts',
            fn (Trail $trail) =>
            $trail->push(Lang::get('breadcrumbs.about'), route('contacts'))
        );

        // Авторизация
        Breadcrumbs::for(
            'auth.login',
            fn (Trail $trail) =>
            $trail->push(Lang::get('breadcrumbs.login'), route('auth.login'))
        );

        // Восстановление пароля
        Breadcrumbs::for(
            'password.create',
            fn (Trail $trail) =>
            $trail->push(Lang::get('breadcrumbs.fogot-password'), route('password.create'))
        );

        // Бонусная программа
        Breadcrumbs::for(
            'discount',
            fn (Trail $trail) =>
            $trail->push('Бонусная программа', route('discount'))
        );
    }
}
