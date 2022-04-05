<ul class="etabs flex">
    @php
        $defaultActive = true;
        foreach ($filterSchema['sub_category'] as $category){
            if($category['selected']){
                $defaultActive = false;
            }
        }
    @endphp
    <li class="tab @if($defaultActive) active @endif " data-action="async">
        <a href="{{ route('courses.index') }}" data-slug="" class="etabs__all">
            <span class="etabs__img">
                <img src="/images/icon16.svg" alt="">
            </span>

            <span class="etabs__href">Все курсы</span>
        </a>
    </li>

    @foreach ($filterSchema['sub_category'] as $category)
        <li class="tab @if($category['selected']) active @endif " @if($block != 'course-grid-block') data-action="async" @endif>
            <a href="{{ route('courses.index', [$category['slug']]) }}" data-slug="{{ $category['slug'] }}" class="etabs__all">
                <span class="etabs__img">
                    <img src="{{ $category['attachment']['url'] }}" alt="">
                </span>

                <span class="etabs__href">{{ $category['name'] }}</span>
            </a>
        </li>
    @endforeach
</ul>
