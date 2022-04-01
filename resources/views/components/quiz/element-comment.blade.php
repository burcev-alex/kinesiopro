@if (isset($list) && !empty(array_filter($list)))
    <h2 class="teachersH2">{{ $title }}</h2>
    <div>{{ $comment }}</div>
    <div class="formIntensive flex">
        @foreach ($list["answer"] as $key=>$item)
            @if (isset($item) && $item != '')
                <div class="formIntensiveRadio">
                    <label class="blockCheckbox">
                        <span>{{ $item }}</span>
                        <input type="radio" name="question[{{ $number }}]" value="{{ $list["point"][$key] }}" id="question-{{ $number }}-{{ $key }}"><span class="checkmark"></span>
                    </label>
                </div>
            @endif
        @endforeach
    </div>
@endif