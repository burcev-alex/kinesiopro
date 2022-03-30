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

        // правила конфиденциальности
        Breadcrumbs::for(
            'privacy_policy',
            fn (Trail $trail) =>
            $trail->push(Lang::get('breadcrumbs.policy'), route('index'))
        );

        // публичная оферта
        Breadcrumbs::for(
            'public_offer',
            fn (Trail $trail) =>
            $trail->push(Lang::get('breadcrumbs.public_offer'), route('index'))
        );

        // О компании
        Breadcrumbs::for(
            'contacts',
            fn (Trail $trail) =>
            $trail->push(Lang::get('breadcrumbs.about'), route('contacts'))
        );
    }
}
