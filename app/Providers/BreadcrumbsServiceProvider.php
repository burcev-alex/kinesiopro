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
            $trail->push(Lang::get('breadcrumbs.contacts'), route('contacts'))
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

        // Преподаватели
        Breadcrumbs::for(
            'teacher.index',
            fn (Trail $trail) =>
            $trail->push('Преподаватели', route('teacher.index'))
        );

        // Видеокурсы
        Breadcrumbs::for(
            'stream.index',
            fn (Trail $trail) =>
            $trail->push('Видеокурсы', route('stream.index'))
        );

        // Покупки
        Breadcrumbs::for(
            'orders.index',
            fn (Trail $trail) =>
            $trail->push(Lang::get('breadcrumbs.personal.profile'), route('profile.index'))->push('Покупки', route('orders.index'))
        );

        // Поиск
        Breadcrumbs::for(
            'search',
            fn (Trail $trail) =>
            $trail->push('Поиск', route('search'))
        );

        // Основные сведения об образовательной организации
        Breadcrumbs::for(
            'about.organizations',
            fn (Trail $trail) =>
            $trail->push('О проекте', route('about.us'))->push('Основные сведения об образовательной организации', route('about.organizations'))
        );

        // Руководство. Педагогический (научно-педагогический) состав
        Breadcrumbs::for(
            'about.headliners',
            fn (Trail $trail) =>
            $trail->push('О проекте', route('about.us'))->push('Руководство. Педагогический (научно-педагогический) состав', route('about.headliners'))
        );

        // Кто мы
        Breadcrumbs::for(
            'about.us',
            fn (Trail $trail) =>
            $trail->push('О проекте', route('about.us'))
        );

        // Оплата робокассов
        Breadcrumbs::for(
            'robokassa.payment',
            fn (Trail $trail) =>
            $trail->push('Заказ', route('orders.index'))
        );
        Breadcrumbs::for(
            'robokassa.success',
            fn (Trail $trail) =>
            $trail->push('Заказ', route('orders.index'))
        );
        Breadcrumbs::for(
            'robokassa.error',
            fn (Trail $trail) =>
            $trail->push('Заказ', route('orders.index'))
        );

        // Оплата сбербанком
        Breadcrumbs::for(
            'success.success',
            fn (Trail $trail) =>
            $trail->push('Заказ', route('orders.index'))
        );
        Breadcrumbs::for(
            'sberbank.error',
            fn (Trail $trail) =>
            $trail->push('Заказ', route('orders.index'))
        );
    }
}
