<?php

declare(strict_types=1);

use App\Orchid\Screens\PlatformScreen;
use App\Orchid\Screens\Role\RoleEditScreen;
use App\Orchid\Screens\Role\RoleListScreen;
use App\Orchid\Screens\User\UserEditScreen;
use App\Orchid\Screens\User\UserListScreen;
use App\Orchid\Screens\User\UserProfileScreen;
use Illuminate\Support\Facades\Route;
use Tabuna\Breadcrumbs\Trail;

use App\Orchid\Screens\Category\CategoryListScreen;
use App\Orchid\Screens\Category\CategoryEditScreen;
use App\Orchid\Screens\Category\CategoryCreateScreen;

use App\Orchid\Screens\Podcast\PodcastListScreen;
use App\Orchid\Screens\Podcast\PodcastEditScreen;
use App\Orchid\Screens\Podcast\PodcastCreateScreen;

use App\Orchid\Screens\Banner\BannersCreateScreen;
use App\Orchid\Screens\Banner\BannersEditScreen;
use App\Orchid\Screens\Banner\BannersListScreen;

use App\Orchid\Screens\Contact\ContactCreateScreen;
use App\Orchid\Screens\Contact\ContactEditScreen;
use App\Orchid\Screens\Contact\ContactListScreen;

use App\Orchid\Screens\Teacher\TeachersCreateScreen;
use App\Orchid\Screens\Teacher\TeachersEditScreen;
use App\Orchid\Screens\Teacher\TeachersListScreen;

use App\Orchid\Screens\Property\CoursePropertyEditScreen;
use App\Orchid\Screens\Property\CoursePropertyListScreen;

use App\Orchid\Screens\Course\CourseEditScreen;
use App\Orchid\Screens\Course\CourseListScreen;
use App\Orchid\Screens\Course\CourseCreateScreen;

use App\Orchid\Screens\Online\OnlineEditScreen;
use App\Orchid\Screens\Online\OnlineListScreen;
use App\Orchid\Screens\Online\OnlineCreateScreen;

use App\Orchid\Screens\News\NewsListScreen;
use App\Orchid\Screens\News\NewsCreateScreen;
use App\Orchid\Screens\News\NewsEditScreen;

use App\Orchid\Screens\Quiz\QuizItemListScreen;
use App\Orchid\Screens\Quiz\QuizItemCreateScreen;
use App\Orchid\Screens\Quiz\QuizItemEditScreen;

use App\Orchid\Screens\Utils\ClearCacheScreen;

/*
|--------------------------------------------------------------------------
| Dashboard Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the need "dashboard" middleware group. Now create something great!
|
*/
Route::screen('/courses', CourseListScreen::class)->name('platform.course.list');
Route::screen('/course-create', CourseCreateScreen::class)->name('platform.course.create');
Route::screen('/courses/{course}/edit', CourseEditScreen::class)->name('platform.course.edit');

Route::screen('/onlines', OnlineListScreen::class)->name('platform.online.list');
Route::screen('/online-create', OnlineCreateScreen::class)->name('platform.online.create');
Route::screen('/onlines/{course}/edit', OnlineEditScreen::class)->name('platform.online.edit');

Route::screen('/properties', CoursePropertyListScreen::class)->name('platform.property.list');
Route::screen('/properties/{property}/edit', CoursePropertyEditScreen::class)->name('platform.property.edit');

Route::screen('/teachers', TeachersListScreen::class)->name('platform.teachers.list');
Route::screen('/teachers/{teachers}/edit', TeachersEditScreen::class)->name('platform.teachers.edit');
Route::screen('/teachers-create', TeachersCreateScreen::class)->name('platform.teachers.create');

Route::screen('/banners', BannersListScreen::class)->name('platform.banners.list');
Route::screen('/banners/{banners}/edit', BannersEditScreen::class)->name('platform.banners.edit');
Route::screen('/banners-create', BannersCreateScreen::class)->name('platform.banners.create');

Route::screen('/categories', CategoryListScreen::class)->name('platform.category.list');
Route::screen('/categories/{category}/edit', CategoryEditScreen::class)->name('platform.category.edit');
Route::screen('/categories-create', CategoryCreateScreen::class)->name('platform.category.create');


Route::screen('/cache-reset', ClearCacheScreen::class)->name('platform.cache.reset');

Route::screen('news/list', NewsListScreen::class)->name('platform.news.list');
Route::screen('news-create', NewsCreateScreen::class)->name('platform.news.create');
Route::screen('news/edit/{news}', NewsEditScreen::class)->name('platform.news.edit');

Route::screen('quiz/list', QuizItemListScreen::class)->name('platform.quiz.list');
Route::screen('quiz-create', QuizItemCreateScreen::class)->name('platform.quiz.create');
Route::screen('quiz/edit/{news}', QuizItemEditScreen::class)->name('platform.quiz.edit');

Route::screen('contacts/list', ContactListScreen::class)->name('platform.contact.list');
Route::screen('contact-create', ContactCreateScreen::class)->name('platform.contact.create');
Route::screen('contact/edit/{news}', ContactEditScreen::class)->name('platform.contact.edit');

Route::screen('podcasts/list', PodcastListScreen::class)->name('platform.podcast.list');
Route::screen('podcasts-create', PodcastCreateScreen::class)->name('platform.podcast.create');
Route::screen('podcasts/edit/{news}', PodcastEditScreen::class)->name('platform.podcast.edit');


// Main
Route::screen('/main', PlatformScreen::class)
    ->name('platform.main');

// Platform > Profile
Route::screen('profile', UserProfileScreen::class)
    ->name('platform.profile')
    ->breadcrumbs(function (Trail $trail) {
        return $trail
            ->parent('platform.index')
            ->push(__('Profile'), route('platform.profile'));
    });

// Platform > System > Users
Route::screen('users/{user}/edit', UserEditScreen::class)
    ->name('platform.systems.users.edit');

// Platform > System > Users > Create
Route::screen('users/create', UserEditScreen::class)
    ->name('platform.systems.users.create')
    ->breadcrumbs(function (Trail $trail) {
        return $trail
            ->parent('platform.systems.users')
            ->push(__('Create'), route('platform.systems.users.create'));
    });

// Platform > System > Users > User
Route::screen('users', UserListScreen::class)
    ->name('platform.systems.users')
    ->breadcrumbs(function (Trail $trail) {
        return $trail
            ->parent('platform.index')
            ->push(__('Users'), route('platform.systems.users'));
    });

// Platform > System > Roles > Role
Route::screen('roles/{roles}/edit', RoleEditScreen::class)
    ->name('platform.systems.roles.edit')
    ->breadcrumbs(function (Trail $trail, $role) {
        return $trail
            ->parent('platform.systems.roles')
            ->push(__('Role'), route('platform.systems.roles.edit', $role));
    });

// Platform > System > Roles > Create
Route::screen('roles/create', RoleEditScreen::class)
    ->name('platform.systems.roles.create')
    ->breadcrumbs(function (Trail $trail) {
        return $trail
            ->parent('platform.systems.roles')
            ->push(__('Create'), route('platform.systems.roles.create'));
    });

// Platform > System > Roles
Route::screen('roles', RoleListScreen::class)
    ->name('platform.systems.roles')
    ->breadcrumbs(function (Trail $trail) {
        return $trail
            ->parent('platform.index')
            ->push(__('Roles'), route('platform.systems.roles'));
    });
