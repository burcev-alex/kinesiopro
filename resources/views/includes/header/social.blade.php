<div class="headerRight flex">
    <ul class="headerMenu flex">
        <li>
            <a href="https://vk.com/physiosapiens" target="_blank">
                <img src="/images/icon6.svg" alt="vk">
            </a>
        </li>
        <li>
            <a href="https://www.youtube.com/channel/UCsxUk35UDtUY4d-6pF0E__A" target="_blank">
                <img src="/images/icon8.svg" alt="youtube">
            </a>
        </li>
    </ul>

    @include('includes.header.search')

    @auth
        @mobile
            <a href="{{ route('profile.index') }}" class="perAccount flex">
                <span>Личный кабинет</span>
            </a>
        @endmobile
        @tablet
            <a href="{{ route('profile.index') }}" class="perAccount flex">
                <span>Личный кабинет</span>
            </a>
        @endtablet
        @desktop
            <div class="enter">
                <div class="enter__desc">Вы вошли как: @if($logged_in_user->unreadNotifications->count() > 0)<span>{{ $logged_in_user->unreadNotifications->count() }}</span>@endif</div>
                <a href="{{ route('profile.index') }}" class="enter__name">{{ $logged_in_user->name }}</a>
            </div>
        @enddesktop
    @else
        <a href="{{ route('auth.login') }}" class="show_autorization_popup perAccount flex">
            <span>Личный кабинет</span>
        </a>
    @endauth


    <ul class="headerMenuSocial flex">
        <li>
            <a href="https://t.me/Physiosapiens_ru" target="_blank">
                <img src="/images/icon10.svg" alt="">
            </a>
        </li>
        <li>
            <a href="https://wa.me/79161997279" target="_blank">
                <img src="/images/icon11.svg" alt="">
            </a>
        </li>
    </ul>
</div>
