<div class="headerRight flex">
    <ul class="headerMenu flex">
        <li>
            <a href="#">
                <img src="/images/icon5.svg" alt="">
            </a>
        </li>

        <li>
            <a href="https://vk.com/physiosapiens" target="_blank">
                <img src="/images/icon6.svg" alt="vk">
            </a>
        </li>

        <li>
            <a href="#">
                <img src="/images/icon7.svg" alt="">
            </a>
        </li>

        <li>
            <a href="https://www.youtube.com/channel/UCsxUk35UDtUY4d-6pF0E__A" target="_blank">
                <img src="/images/icon8.svg" alt="youtube">
            </a>
        </li>
    </ul>

    <form action="" class="headerSearch">
        <a href="#" class="headerSearch__btn"></a>
    </form>

    @if (Auth::check())
        <a href="{{ route('logout') }}" class="perAccount flex">
            <span>Личный кабинет</span>
        </a>
    @else
        <a href="{{ route('register.create') }}" class="show_autorization_popup perAccount flex">
            <span>Авторизация</span>
        </a>
    @endif


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
