<div class="profile">
    <div class="profile__title">Профиль</div>

    <ul class="buyList">
        <li class="buyList__active">
            <a href="#">Покупки</a>
        </li>

        <li>
            <ul class="buyListIn">
                <li>
                    <a href="#">Вебинары</a>
                </li>

                <li>
                    <a href="#">Семинары</a>
                </li>

                <li>
                    <a href="#">Конференции</a>
                </li>

                <li>
                    <a href="#">Марафоны</a>
                </li>

                <li>
                    <a href="#">Видеокурсы</a>
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