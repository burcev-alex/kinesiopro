## KINESIO (Current: Laravel 8.*) ([Demo](https://kinesio.ru/))

Список сторонних решений, которые применены в проекте, с ссылками на репозитории:

- [Meta](https://github.com/davmixcool/laravel-meta-manager).
- [Trailing SlashMeta 1](https://github.com/fsasvari/laravel-trailing-slash).
- [Trailing SlashMeta 2](https://github.com/xinningsu/laravel-route-trailing-slash).


### Команды Docker.
**Запуск контейнера**
* docker-compose up -d --build site

**Внутренние команды**
* docker-compose run --rm composer update
* docker-compose run --rm npm run production
* docker-compose run --rm artisan migrate
* docker-compose run --rm --service-ports npm run watch

**Остановка контейнера**
* docker-compose down

### Правила именования коммитов.

**Шаблон:**
* *<тип>*(*<пространство изменений>*): *<сообщение>*
* *<тип>*(task #*<ID задачи в багтрекере>*): *<сообщение>*

**Есть несколько заранее определенных типов:**

* feat — используется при добавлении новой функциональности уровня приложения
* fix — если исправили какую-то серьезную багу
* docs — всё, что касается документации
* style — исправляем опечатки, исправляем форматирование
* refactor — рефакторинг кода приложения
* test — всё, что связано с тестированием
* chore — обычное обслуживание кода

**Пример использования:**
1. feat(task #160): Создание скрипта перехвата веб-хуков
1. fix(shop): Вывод сопутствующих товаров в детальной карточке
1. feat(task #12): minor