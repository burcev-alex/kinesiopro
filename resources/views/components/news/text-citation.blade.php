@if (isset($text) || isset($autor))
    @isset($text)
        <div class="paragraf">
            {!! $text !!}
        </div>
    @endisset
    @isset($autor)
        <p class="text">{{ $autor }}</p>
    @endisset
@endif
