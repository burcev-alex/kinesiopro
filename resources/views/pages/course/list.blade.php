@extends('layouts.app')

@section('metaLabels')
    @parent
    @include('meta::manager', [
        'title' => 'KinesioPro | Официальные курсы Maitland, PNF, Bobath, CIMT, SEAS, Нейродинамика',
        'description' =>
            'Курсы физической реабилитации, мануальной терапии и лечебной физкультуры. Кинезио (кинезитерапия, кинезиотерапия, кинезотерапия)',
    ])
@stop

@push('before-styles')
    <link href="{{ mix('css/slick.css') }}" media="all" type="text/css" rel="stylesheet">
@endpush

@section('content')

    <h1 class="width titleH1">Расписание семинаров</h1>


    <!--Start schedule-->
    <section class="schedule width">
        <div class="scheduleContent">
            <div class="scheduleTop">
                <ul class="scheduleList flex">
                    <li>
                        <a href="#" class="active">Он-лайн</a>
                    </li>

                    <li>
                        <div class="scheduleSlider">
                            <span class="scheduleSlider__btn"></span>
                        </div>
                    </li>

                    <li>
                        <a href="#">Оффлайн</a>
                    </li>
                </ul>

                <a href="#" class="schedule__all">Посмотреть все</a>
            </div>

            <div class="scheduleBlock">
                <div class="selectsBlock flex">
                    <select class="select">
                        <option value="1">Москва</option>
                        <option value="2">Москва 2</option>
                        <option value="3">Москва 3</option>
                    </select>

                    <select class="select">
                        <option value="1">Онлайн</option>
                        <option value="2">Оффлайн</option>
                    </select>

                    <select class="select disabled" disabled>
                        <option value="1">Преподаватель</option>
                        <option value="2">Преподаватель 2</option>
                    </select>

                    <select class="select">
                        <option value="1">Февраль 2022</option>
                        <option value="2">Март 2022</option>
                        <option value="2">Апрель 2022</option>
                    </select>

                    <select class="select disabled" disabled>
                        <option value="1">Направление</option>
                        <option value="2">Направление 2</option>
                    </select>
                </div>


                <div class="tab-container">
                    <div class="scroll">
                        <ul class="etabs flex">
                            <li class="tab active">
                                <a href="#all" class="etabs__all">
                                    <span class="etabs__img">
                                        <img src="/images/icon16.svg" alt="">
                                    </span>

                                    <span class="etabs__href">Все курсы</span>
                                </a>
                            </li>

                            <li class="tab">
                                <a href="#rehabTeam" class="etabs__all">
                                    <span class="etabs__img">
                                        <img src="/images/icon17.svg" alt="">
                                    </span>

                                    <span class="etabs__href">REHABTeam</span>
                                </a>
                            </li>

                            <li class="tab">
                                <a href="#texn" class="etabs__all">
                                    <span class="etabs__img">
                                        <img src="/images/icon18.svg" alt="">
                                    </span>

                                    <span class="etabs__href">Тематические курсы</span>
                                </a>
                            </li>

                            <li class="tab">
                                <a href="#maitland" class="etabs__all">
                                    <span class="etabs__img">
                                        <img src="/images/icon19.svg" alt="">
                                    </span>

                                    <span class="etabs__href">Maitland</span>
                                </a>
                            </li>

                            <li class="tab">
                                <a href="#bobath" class="etabs__all">
                                    <span class="etabs__img">
                                        <img src="/images/icon20.svg" alt="">
                                    </span>

                                    <span class="etabs__href">Bobath</span>
                                </a>
                            </li>

                            <li class="tab">
                                <a href="#pnf" class="etabs__all">
                                    <span class="etabs__img">
                                        <img src="/images/icon21.svg" alt="">
                                    </span>

                                    <span class="etabs__href">PNF</span>
                                </a>
                            </li>

                            <li class="tab">
                                <a href="#neurodynamics" class="etabs__all">
                                    <span class="etabs__img">
                                        <img src="/images/icon22.svg" alt="">
                                    </span>

                                    <span class="etabs__href">Нейродинамика</span>
                                </a>
                            </li>
                        </ul>
                    </div>

                    <div class="tab-content">
                        <div>
                            <div class="itemBlock">
                                @include('includes.course.list', ['courses' => $courses])
                            </div>

                            <a href="#" class="loadBtn flex">
                                <span>Показать еще</span>
                            </a>
                        </div>
                    </div>
                </div>


            </div>
        </div>
    </section>
    <!--End schedule-->

@endsection

@push('before-scripts')
    @include('includes.scripts', [
    'list' => [
        mix('js/plugins/slick.js')
    ],
    ])
@endpush

@push('after-scripts')
    @include('includes.scripts', [
    'list' => [
        mix('js/course_page_script.js')
    ],
    ])
@endpush