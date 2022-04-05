@extends('layouts.app')

@section('metaLabels')
    @parent
    @include('meta::manager', [
        'title' => $seo['title'],
        'description' => $seo['description'],
    ])
@stop

@push('before-styles')
    <link href="{{ mix('css/slick.css') }}" media="all" type="text/css" rel="stylesheet">
@endpush

@section('content')

    @include('includes.partials.breadcrumbs')
    <h1 class="width titleH1">{{ $seo['h1'] }}</h1>


    <!--Start schedule-->
    <section class="schedule width">
        <form id="filter-form" action="{{ route('courses.index') }}">
            <div class="scheduleContent">
                <div class="scheduleTop">
                    <ul class="scheduleList flex">
                        <li>
                            <a href="#">Он-лайн</a>
                        </li>

                        <li>
                            <div class="scheduleSlider offline">
                                <span class="scheduleSlider__btn"></span>
                            </div>
                        </li>

                        <li>
                            <a href="{{ route('courses.index') }}" class="active">Оффлайн</a>
                        </li>
                    </ul>

                    <a href="#" class="schedule__all">Посмотреть все</a>
                </div>

                <div class="scheduleBlock">
                    @include('includes.course.filter', ['block' => 'course-grid-block'])

                    <div class="tab-container">
                        <div class="scroll">
                            @include('includes.course.categories', ['block' => 'course-grid-block'])
                        </div>

                        <div class="tab-content">
                            <div id="course-grid-block">
                                <div class="itemBlock" id="course-grid-block-elements">
                                    @include('includes.course.list', ['courses' => $courses])
                                </div>

                                <div class="pagination-block">
                                    @include('includes.pagination', ['block' => 'course-grid-block-elements'])
                                </div>
                            </div>
                        </div>
                    </div>


                </div>
            </div>
        </form>
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
        mix('js/plugins/mask.js'),
        mix('js/course_page_script.js')
    ],
    ])
@endpush