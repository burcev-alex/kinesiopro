@foreach ($teachers as $teacher)
    <div class="teachersItem flex">
        <img src="{{ $teacher->attachment != null ? $teacher->attachment->url() : '' }}" alt="{{ $teacher->full_name }}">

        <div class="teachersItemBlock">
            <h3 class="teachersItemBlock__name">{{ $teacher->full_name }}</h3>
            <p>{!! $teacher->description !!}</p>
        </div>
    </div>
@endforeach
