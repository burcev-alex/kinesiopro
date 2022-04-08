<!--Start header-->
<header class="header">
    <div class="headerIn flex  width">
        <a href="{{ route('index') }}" class="headerLogo">
            <img src="/images/headerLogo.svg" alt="">
        </a>

        @include('includes.header.nav', ['sufix' => ''])

        @include('includes.header.social')
    </div>

    <button type="button" class="headerBtn">
        <span></span>
        <span></span>
        <span></span>
    </button>

    @mobile
    <div class="mobilBlock">
        @include('includes.header.nav', ['sufix' => 'Mobil'])

        <div class="mobilBlockBtn">
            <div class="headerRight flex">
                <div class="mobilBlockBtnBlock flex">
                    @include('includes.header.search')

                    @auth
                        <div class="enter">
                            <div class="enter__desc">Вы вошли как: @if($logged_in_user->unreadNotifications->count() > 0)<span>{{ $logged_in_user->unreadNotifications->count() }}</span>@endif</div>
                            <a href="{{ route('profile.index') }}" class="enter__name">{{ $logged_in_user->name }}</a>
                        </div>
                    @else
                        <a href="{{ route('register.create') }}" class="show_autorization_popup perAccount flex">
                            <span>Авторизация</span>
                        </a>
                    @endauth
                </div>

                <ul class="headerMenu flex">
                    <li>
                        <a href="#">
                            <img src="/images/icon5.svg" alt="">
                        </a>
                    </li>

                    <li>
                        <a href="#">
                            <img src="/images/icon6.svg" alt="">
                        </a>
                    </li>

                    <li>
                        <a href="#">
                            <img src="/images/icon7.svg" alt="">
                        </a>
                    </li>

                    <li>
                        <a href="#">
                            <img src="/images/icon8.svg" alt="">
                        </a>
                    </li>
                </ul>

                <ul class="headerMenuSocial flex">
                    <li>
                        <a href="#">
                            <img src="/images/icon10.svg" alt="">
                        </a>
                    </li>

                    <li>
                        <a href="#">
                            <img src="/images/icon11.svg" alt="">
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    @endmobile
</header>
<!--End header-->
