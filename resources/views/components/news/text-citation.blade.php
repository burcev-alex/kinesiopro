@if (isset($text) || isset($autor))
    @isset($text)
        <div class="left-col">
            <div class="text">
                {!! $text !!}
            </div>
        </div>
    @endisset
    @isset($autor)
        <div class="right-col">
            <p class="text">{{ $autor }}</p>
        </div>
    @endisset
@endif
