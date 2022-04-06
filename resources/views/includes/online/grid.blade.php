@foreach ($onlines as $online)
    <li>
        <a href="{{ route('online.single', ['slug' => $online->slug]) }}" class="blogItem__href">
        <span class="blogItem__img2">
            <img src="{{ $online->attachment != null ? $online->attachment->url() : '' }}" alt="{{ $online->title }}" alt="{{ $online->title }}">
        </span>

            <span class="blogItem__title">
                <span>{{ $online->title }}</span>
        </span>
        </a>

        <p>{!! $online->preview_format !!}</p>
    </li>
@endforeach
