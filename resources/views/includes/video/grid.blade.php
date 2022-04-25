@foreach ($articles as $article)
    <div class="videoItem">
        <a href="{{ route('stream.single', ['slug' => $article->slug]) }}">
            <span class="videoItem__img">
                <img src="{{ $article->attachment != null ? $article->attachment->url() : '' }}" alt="{{ $article->title }}">
            </span>

            <span class="videoItem__title">{{ $article->title }}</span>
        </a>

        <p class="videoItem__paragraf">{!! $article->preview_format !!}</p>
    </div>
@endforeach
