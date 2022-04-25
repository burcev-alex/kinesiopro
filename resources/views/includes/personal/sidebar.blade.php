<div class="profile">
    <div class="profile__title">Профиль</div>

    <ul class="buyList">
        <li class="buyList__active">
            <a href="{{ route('orders.index') }}">Покупки</a>
        </li>

        <li>
            <ul class="buyListIn">
                <li>
                    <a href="{{ route('orders.index', ['type' => 'webinar']) }}">Вебинары</a>
                </li>

                <li>
                    <a href="{{ route('orders.index', ['type' => 'course']) }}">Семинары</a>
                </li>

                <li>
                    <a href="{{ route('orders.index', ['type' => 'conference']) }}">Конференции</a>
                </li>

                <li>
                    <a href="{{ route('orders.index', ['type' => 'marafon']) }}">Марафоны</a>
                </li>

                <li>
                    <a href="{{ route('orders.index', ['type' => 'video']) }}">Видеокурсы</a>
                </li>
            </ul>
        </li>
    </ul>

    <ul class="profileList">
        {{-- <li>
            <a href="">Сертификаты</a>
        </li> --}}

        <li>
            <a href="{{ route('profile.notifications') }}">Уведомления 
                @if($logged_in_user->unreadNotifications->count() > 0) 
                    <span>{{ $logged_in_user->unreadNotifications->count() }}</span>
                @endif
            </a>
        </li>

        <li>
            <a href="mailto:kineziopro@gmail.com">Обратная связь</a>
        </li>
    </ul>
</div>

<a href="{{ route('courses.index') }}" class="flex scheduleBtn">
    <span>Перейти к расписанию занятий</span>
</a>