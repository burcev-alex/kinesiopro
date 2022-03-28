<!--Start schedule-->
<section class="schedule width">
    <h2 class="schedule__title">Расписание</h2>

    <form id="filter-form" action="/courses/">
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
                <div class="selectsBlock flex">
                    <select name="city" class="select">
                        <option value="">Город</option>
                        @foreach ($filterSchema['filters']['city']['options'] as $item)
                            <option value="{{ $item['value'] }}">{{ $item['title'] }}</option>
                        @endforeach
                    </select>

                    <select name="format" class="select">
                        <option value="">Формат</option>
                        @foreach ($filterSchema['filters']['format']['options'] as $item)
                            <option value="{{ $item['value'] }}">{{ $item['title'] }}</option>
                        @endforeach
                    </select>

                    <select name="teacher" class="select">
                        <option value="">Преподаватель</option>
                        @foreach ($filterSchema['filters']['teachers']['options'] as $item)
                            <option value="{{ $item['slug'] }}">{{ $item['full_name'] }}</option>
                        @endforeach
                    </select>

                    <select name="period" class="select">
                        <option value="">Время</option>
                        @foreach ($filterSchema['filters']['periods']['options'] as $item)
                            <option value="{{ $item['value'] }}">{{ $item['title'] }}</option>
                        @endforeach
                    </select>

                    <select name="direct" class="select">
                        <option value="">Направление</option>
                        @foreach ($filterSchema['filters']['direct']['options'] as $item)
                            <option value="{{ $item['value'] }}">{{ $item['title'] }}</option>
                        @endforeach
                    </select>
                </div>


                <div class="tab-container">
                    <div class="scroll">
                        <ul class="etabs flex">
                            <li class="tab active">
                                <a href="javascript:" data-slug="" class="etabs__all">
                                    <span class="etabs__img">
                                        <img src="/images/icon16.svg" alt="">
                                    </span>

                                    <span class="etabs__href">Все курсы</span>
                                </a>
                            </li>

                            @foreach ($filterSchema['sub_category'] as $category)
                            <li class="tab">
                                <a href="javascript:" data-slug="{{ $category['slug'] }}" class="etabs__all">
                                    <span class="etabs__img">
                                        <img src="{{ $category['attachment']['url'] }}" alt="">
                                    </span>

                                    <span class="etabs__href">{{ $category['name'] }}</span>
                                </a>
                            </li>
                            @endforeach
                        </ul>
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
