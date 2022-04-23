<div class="selectsBlock flex">
    <select name="city" class="select @if(!$fields['city']) disabled @endif" @if(!$fields['city']) disabled @endif>
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

    <select name="format" class="select @if(!$fields['format']) disabled @endif" @if(!$fields['format']) disabled @endif>
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

    <select name="teacher" class="select @if(!$fields['teacher']) disabled @endif" @if(!$fields['teacher']) disabled @endif>
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

    <select name="period" class="select @if(!$fields['period']) disabled @endif" @if(!$fields['period']) disabled @endif>
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

    <select name="direct" class="select @if(!$fields['direct']) disabled @endif" @if(!$fields['direct']) disabled @endif>
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
