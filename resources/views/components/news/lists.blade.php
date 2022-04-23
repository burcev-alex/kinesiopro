@if (isset($list) && !empty(array_filter($list)))
    <div class="blockMarafon">
        @if(isset($title))
        <h3 class="blockMarafon__title">{{ $title }}</h3>
        @endif
        @php
            if($type == 'cross'){
                $typeClass = 'blockMarafonList2';
            }
            else{
                $typeClass = '';
            }
        @endphp
        <ul class="blockMarafonList {{ $typeClass }}">
            @foreach ($list as $item)
                @if (isset($item) && $item != '')
                    <li>
                        <span>{{ $item }}</span>
                    </li>
                @endif
            @endforeach
        </ul>
    </div>
@endif