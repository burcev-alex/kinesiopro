@extends('layouts.app')

@section('metaLabels')
    @parent
    @include('meta::manager', [
        'title' => 'KinesioPro | Официальные курсы Maitland, PNF, Bobath, CIMT, SEAS, Нейродинамика',
        'description' =>
            'Курсы физической реабилитации, мануальной терапии и лечебной физкультуры. Кинезио (кинезитерапия, кинезиотерапия, кинезотерапия)',
    ])
@stop

@section('content')

    @include('includes.partials.breadcrumbs')
    <h1 class="width titleH1">Основные сведения об образовательной организации</h1>

    <div class="guideBlock width">
        <div class="guideBlockIn">
            <ul class="guideBlockList">
                <li>
                    <p><b>Полное название:</b> ООО «Лаборатория физической терапии»</p>
                </li>

                <li>
                    <p><b>Дата создания:</b> 19 октября 2018 г.</p>
                </li>
            </ul>
        </div>

        <div class="guideBlockIn">
            <ul class="guideBlockList">
                <li>
                    <p><b>Учредители:</b> Темичев Георгий Витальевич, Цогоева Ирина Константиновна</p>
                </li>

                <li>
                    <p><b>Адрес:</b> 119071, г. Москва, Ленинский проспект, 15, IV-V</p>
                </li>
            </ul>
        </div>

        <div class="guideBlockIn">
            <ul class="guideBlockList">
                <li>
                    <b class="guideBlockIn__title">Режим работы офиса:</b>
                </li>
                <li>
                    <p><b>Пн-Пт:</b> 10:00-17:00</p>
                </li>

                <li>
                    <p><b>Сб-Вс:</b> выходные дни</p>
                </li>
            </ul>
        </div>

        <div class="guideBlockIn">
            <ul class="guideBlockList">
                <li>
                    <p><b>Контактные телефоны:</b>
                        <a href="tel:+79161997279," class="guideBlock__phone">+7(916) 199-72-79,</a>
                        <a href="tel:+79250386132" class="guideBlock__phone">+7(925)038-61-32</a>
                    </p>
                </li>

                <li>
                    <p><b>Адрес электронной почты:</b>
                        <a href="mailto:info@kinesiopro.ru" class="guideBlock__mail">info@kinesiopro.ru</a>,
                    </p>
                </li>

                <li>
                    <p><b>Сайт:</b>
                        <a href="#" class="guideBlock__mail">physiosapiens.ru</a>,
                        <a href="#" class="guideBlock__mail">physiosapiens.ru</a>
                    </p>
                </li>
            </ul>
        </div>
    </div>

@endsection
