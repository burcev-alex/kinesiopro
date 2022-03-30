@foreach ($courses as $course)
    <div class="item flex">
        <div class="itemLeft">
            <div class="itemDate">
                <span class="itemDate__date">{{ $course->start_date->format('d.m.Y') }} -</span>
                <span class="itemDate__date">{{ $course->finish_date->format('d.m.Y') }}</span>
                <span class="itemDate__time">{{ $course->start_date->format('H:i') }} -
                    {{ $course->finish_date->format('H:i') }}</span>
            </div>
        </div>

        <div class="itemCenter">
            <p>{{ $course->name }}</p>
            <div class="itemCenter__city">{{ $course->city_display }}</div>
            @foreach ($course->teachers as $teacher)
                <div class="itemCenter__name">{{ $teacher->full_name }}</div>
            @endforeach
        </div>

        <div class="itemRight">
            <div class="itemRight__price">{{ $course->price_format }} ₽</div>

            <a href="{{ route('courses.card', ['slug' => $course->slug]) }}" class="itemRight__href flex">
                <span>Записаться</span>
            </a>
        </div>

        @if($course->blocks->count() > 0)
        <div class="itemBottom">
            <div class="itemBottom__title">Блоки курса</div>

            <div class="itemSlider">
                @foreach ($course->blocks as $block)
                    <div>
                        <div class="blockCourse">
                            <div class="blockCourse__time">{{ $block->start_date->format('d.m.Y') }} - {{ $block->finish_date->format('d.m.Y') }} ({{ $block->diff_day }} {{trans_choice('день|дня|дней', $block->diff_day)}})</div>
                            <div class="blockCourse__text">{{ $block->title }}</div>
                            <div class="blockCourse__name">{{ $block->teacher->full_name }}</div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        @endif
    </div>
@endforeach
