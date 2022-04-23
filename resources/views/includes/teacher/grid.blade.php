@foreach ($teachers as $teacher)
    <div class="teachersItem flex">
        <img src="{{ $teacher->attachment != null ? $teacher->attachment->url() : '' }}" alt="{{ $teacher->full_name }}">

        <div class="teachersItemBlock">
            <h3 class="teachersItemBlock__name"><a href="{{ route('teacher.single', ['slug' => $teacher->slug]) }}">{{ $teacher->full_name }}</a></h3>
            <p>{!! $teacher->description !!}</p>
        </div>
    </div>
@endforeach
