@if (isset($title) || isset($text))
    @isset($title)
        <h2 class="mainTitle">{{ $title }}</h2>
    @endisset
    @isset($text)
        @if(strlen($text) > 20)
        <div class="textBlock">
            <p>
            {!! $text !!}
            </p>
        </div>
        @endif
    @endisset
@endif
