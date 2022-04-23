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
    <h1 class="width titleH1">Руководство. Педагогический (научно-педагогический) состав</h1>
    <div class="guideBlock width">
        <div class="guideBlockIn">
            <h2 class="guideBlock__title">Руководство:</h2>

            <ul class="guideBlockList">
                <li>
                    <p><b>Ректор:</b> Темичев Георий Витальевич</p>
                </li>

                <li>
                    <p><b>Телефон:</b> <a href="tel:+79250386132" class="guideBlock__phone">+7(925)038-61-32</a></p>
                </li>

                <li>
                    <p><b>Адрес электронной почты:</b>
                        <a href="mailto:info@kinesiopro.ru" class="guideBlock__mail">info@kinesiopro.ru</a>
                    </p>
                </li>

                <li>
                    <p>Сб-Вс: выходные дни</p>
                </li>
            </ul>
        </div>


        <div class="guideBlockIn">
            <h2 class="guideBlock__title">Педагогический (научно-педагогический) состав:</h2>

            <ul class="guideBlockList2">
                <li>
                    <a href="#">Темичев Георий Витальевич</a>
                </li>

                <li>
                    <a href="#">Горковский Дмитрий Владимирович</a>
                </li>

                <li>
                    <a href="#">Осокина Марина Николаевна</a>
                </li>
            </ul>
        </div>
    </div>

@endsection
