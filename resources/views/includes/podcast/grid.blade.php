@foreach ($podcasts as $podcast)
    <li>
        <a href="{{ route('podcast.single', ['slug' => $podcast->slug]) }}" class="blogItem__href">
            <span class="blogItem__date">{{ $podcast->publish_date }}</span>

        <span class="blogItem__img2">
            <img src="{{ $podcast->attachment != null ? $podcast->attachment->url() : '' }}" alt="{{ $podcast->title }}">
        </span>

            <span class="blogItem__title">
                <span>{{ $podcast->title }}</span>
        </span>
        </a>
    </li>
@endforeach
