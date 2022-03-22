@if (isset($title) || isset($text))
    <div class="text-block">
        @isset($title)
            <h2 class="sub-title">{{ $title }}</h2>
        @endisset
        @isset($text)
            @if(strlen($text) > 20)
            <div class="text">
                {!! $text !!}
            </div>
            @endif
        @endisset
    </div>
@endif
