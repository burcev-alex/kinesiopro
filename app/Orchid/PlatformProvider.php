<?php

namespace App\Orchid;

use Orchid\Platform\Dashboard;
use Orchid\Platform\ItemPermission;
use Orchid\Platform\OrchidServiceProvider;
use Orchid\Screen\Actions\Menu;
use Orchid\Support\Color;

class PlatformProvider extends OrchidServiceProvider
{
    /**
     * Boot
     *
     * @param Dashboard $dashboard
     */
    public function boot(Dashboard $dashboard): void
    {
        parent::boot($dashboard);

        // ...
    }

    /**
     * RegisterMainMenu
     *
     * @return Menu[]
     */
    public function registerMainMenu(): array
    {
        return [

            Menu::make('Специализации')
                ->route('platform.category.list')
                ->icon('list')->title('Каталог'),

            Menu::make('Очные курсы')
                ->route('platform.course.list')
                ->icon('list'),

            Menu::make('Онлайн-курсы')
                ->route('platform.online.list')
                ->icon('list'),

            Menu::make('Конструктор контента видео-курсов')
                ->route('platform.stream.list')
                ->icon('list'),

            Menu::make('Подкасты')
                ->route('platform.podcast.list')
                ->icon('list'),

            Menu::make('Характеристики')
                ->route('platform.property.list')
                ->icon('list')
                ->title('Справочники'),

            Menu::make('Преподаватели')
                ->route('platform.teachers.list')
                ->icon('list'),

            Menu::make('Блог')
                ->icon('list')
                ->route('platform.news.list')->title('Контент'),

            Menu::make('Тесты')
                ->route('platform.quiz.list')
                ->icon('list'),
                
            Menu::make('Баннеры')
                ->route('platform.banners.list')
                ->icon('list'),
                
            Menu::make('Контакты')
                ->route('platform.contact.list')
                ->icon('list'),

            Menu::make('Список заказов')
                ->route('platform.orders.list')
                ->icon('list')
                ->title('Заказы'),
    
            Menu::make('Сброс кеша')
                ->route('platform.cache.reset')
                ->icon('list')
                ->title('Утилиты'),
    
            Menu::make('Пользователи')
                ->route('platform.systems.users')
                ->icon('list')
                ->title('Система'),
    
            Menu::make('Роли')
                ->route('platform.systems.roles')
                ->icon('list'),
        ];
    }

    /**
     * RegisterProfileMenu
     *
     * @return Menu[]
     */
    public function registerProfileMenu(): array
    {
        return [
            Menu::make('Profile')
                ->route('platform.profile')
                ->icon('user'),
        ];
    }

    /**
     * RegisterPermissions
     *
     * @return ItemPermission[]
     */
    public function registerPermissions(): array
    {
        return [
            ItemPermission::group(__('System'))
                ->addPermission('platform.systems.roles', __('Roles'))
                ->addPermission('platform.systems.users', __('Users')),
        ];
    }

    /**
     * RegisterSearchModels
     *
     * @return string[]
     */
    public function registerSearchModels(): array
    {
        return [];
    }
}
