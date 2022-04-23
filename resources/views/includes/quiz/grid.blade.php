@foreach ($articles as $article)
    <li>
        <a href="{{ route('tests.single', ['slug' => $article->slug]) }}" class="blogItem__href">
            <span class="blogItem__img">
                <img src="{{ $article->attachment != null ? $article->attachment->url() : '' }}" alt="{{ $article->title }}">
            </span>

            <span class="blogItem__title">
                <span>{{ $article->title }}</span>
            </span>
        </a>

        <p>{!! $article->preview_format !!}</p>
    </li>
@endforeach
