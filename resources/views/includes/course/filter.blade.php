<div class="selectsBlock flex">
    <select name="city" class="select">
        <option value="">Город</option>
        @if(array_key_exists('city', $filterSchema['filters']))
            @foreach ($filterSchema['filters']['city']['options'] as $item)
                @php
                    $selected = $item['selected'] ? ' selected' : '';
                @endphp
                <option value="{{ $item['value'] }}"{{ $selected }}>{{ $item['title'] }}</option>
            @endforeach
        @endif
    </select>

    <select name="format" class="select">
        <option value="">Формат</option>
        @if(array_key_exists('format', $filterSchema['filters']))
            @foreach ($filterSchema['filters']['format']['options'] as $item)
                @php
                    $selected = $item['selected'] ? ' selected' : '';
                @endphp
                <option value="{{ $item['value'] }}"{{ $selected }}>{{ $item['title'] }}</option>
            @endforeach
        @endif
    </select>

    <select name="teacher" class="select">
        <option value="">Преподаватель</option>
        @if(array_key_exists('teachers', $filterSchema['filters']))
            @foreach ($filterSchema['filters']['teachers']['options'] as $item)
                @php
                    $selected = $item['selected'] ? ' selected' : '';
                @endphp
                <option value="{{ $item['value'] }}"{{ $selected }}>{{ $item['title'] }}</option>
            @endforeach
        @endif
    </select>

    <select name="period" class="select">
        <option value="">Время</option>
        @if(array_key_exists('periods', $filterSchema['filters']))
            @foreach ($filterSchema['filters']['periods']['options'] as $item)
                @php
                    $selected = $item['selected'] ? ' selected' : '';
                @endphp
                <option value="{{ $item['value'] }}"{{ $selected }}>{{ $item['title'] }}</option>
            @endforeach
        @endif
    </select>

    <select name="direct" class="select">
        <option value="">Направление</option>
        @if(array_key_exists('direct', $filterSchema['filters']))
            @foreach ($filterSchema['filters']['direct']['options'] as $item)
                @php
                    $selected = $item['selected'] ? ' selected' : '';
                @endphp
                <option value="{{ $item['value'] }}"{{ $selected }}>{{ $item['title'] }}</option>
            @endforeach
        @endif
    </select>
</div>
