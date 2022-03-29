<!--Start schedule-->
<section class="schedule width">
    <h2 class="schedule__title">Расписание</h2>

    <form id="filter-form" action="{{ route('courses.index') }}">
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

                <a href="{{ route('courses.index') }}" class="schedule__all">Посмотреть все</a>
            </div>
            
            <div class="scheduleBlock">
                @include('includes.course.filter', ['block' => 'home-page-block-course'])

                <div class="tab-container">
                    <div class="scroll">
                        @include('includes.course.categories', ['block' => 'home-page-block-course'])
                    </div>

                    <div class="tab-content">
                        <div id="home-page-block-course">
                            <div class="itemBlock">
                                
                            </div>

                            <div class="pagination-block">
                                <a href="#" class="loadBtn flex">
                                    <span>Показать еще</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>


            </div>
        </div>
    </form>
</section>
<!--End schedule-->