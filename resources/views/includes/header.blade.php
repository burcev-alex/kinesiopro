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
                    <form action="" class="headerSearch">
                        <a href="#" class="headerSearch__btn"></a>
                    </form>

                    <a href="#" class="perAccount flex">
                        <span>Личный кабинет</span>
                    </a>
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
