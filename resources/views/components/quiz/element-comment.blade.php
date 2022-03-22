{{ $title }} | {{ $comment }}
@if (isset($list) && !empty(array_filter($list)))
    <div class="list-block">
        <ul>
            @foreach ($list as $item)
                @if (isset($item) && $item != '')
                    <li>
                        <p>{{ $item }}</p>
                    </li>
                @endif
            @endforeach
        </ul>
    </div>
@endif