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
                        <a href="{{ route('profile.index') }}" class="perAccount flex">
                            <span>Личный кабинет</span>
                        </a>
                    @else
                        <a href="{{ route('register.create') }}" class="show_autorization_popup perAccount flex">
                            <span>Личный кабинет</span>
                        </a>
                    @endauth
                </div>

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
        </div>
    </div>
    @endmobile
</header>
<!--End header-->
