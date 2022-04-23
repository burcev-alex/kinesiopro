@foreach ($articles as $article)
    <li>
        <a href="{{ route('blog.single', ['slug' => $article->slug]) }}" class="blogItem__href">
            <span class="blogItem__date">{{ $article->publish_date }}</span>

            <span class="blogItem__img">
                <img src="{{ $article->attachment != null ? $article->attachment->url() : '' }}" alt="{{ $article->title }}">
            </span>

            <span class="blogItem__title">
                <span>{{ $article->title }}</span>
            </span>
        </a>
    </li>
@endforeach
