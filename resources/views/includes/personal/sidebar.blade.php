<div class="profile">
    <div class="profile__title">{{ $title }}</div>
    @php
        $currentRoute = \Request::path();
    @endphp

    <ul class="buyList @if(\Request::route()->getName() == 'orders.index') active @endif">
        <li class="buyList__active">
            <a href="{{ route('orders.index') }}">Покупки</a>
        </li>

        <li>
            <ul class="buyListIn @if(\Request::route()->getName() == 'orders.index') active @endif ">
                <li>
                    <a href="{{ route('orders.index', ['type' => 'webinar']) }}" @if($currentRoute == 'orders/webinar') class="active" @endif>Вебинары</a>
                </li>

                <li>
                    <a href="{{ route('orders.index', ['type' => 'course']) }}" @if($currentRoute == 'orders/course') class="active" @endif>Семинары</a>
                </li>

                <li>
                    <a href="{{ route('orders.index', ['type' => 'conference']) }}" @if($currentRoute == 'orders/conference') class="active" @endif>Конференции</a>
                </li>

                <li>
                    <a href="{{ route('orders.index', ['type' => 'marafon']) }}" @if($currentRoute == 'orders/marafon') class="active" @endif>Марафоны</a>
                </li>

                <li>
                    <a href="{{ route('orders.index', ['type' => 'video']) }}" @if($currentRoute == 'orders/video') class="active" @endif>Видеокурсы</a>
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

<a href="{{ route('courses.index') }}" class="flex scheduleBtn block">
    <span>Перейти к расписанию занятий</span>
</a>