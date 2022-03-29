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
        // Блог
        Breadcrumbs::for(
            'blog',
            fn (Trail $trail) =>
            $trail->push(Lang::get('breadcrumbs.blog'), route('index'))
        );

        // Контакты
        Breadcrumbs::for(
            'contacts',
            fn (Trail $trail) =>
            $trail->push(Lang::get('breadcrumbs.contacts'), route('index'))
        );

        // Подкасты
        Breadcrumbs::for(
            'podcast',
            fn (Trail $trail) =>
            $trail->push(Lang::get('breadcrumbs.podcast'), route('index'))
        );

        // Мои данные
        Breadcrumbs::for(
            'profile.index',
            fn (Trail $trail) =>
            $trail->push(Lang::get('breadcrumbs.personal.profile'), route('index'))
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

        // контакты
        Breadcrumbs::for(
            'contacts',
            fn (Trail $trail) =>
            $trail->push(Lang::get('breadcrumbs.contacts'), route('index'))
        );

        // О компании
        Breadcrumbs::for(
            'about',
            fn (Trail $trail) =>
            $trail->push(Lang::get('breadcrumbs.about'), route('index'))
        );

        // История заказов
        Breadcrumbs::for(
            'recovery',
            fn (Trail $trail) =>
            $trail->push(Lang::get('breadcrumbs.recovery'), route('recovery'))
        );
    }
}
