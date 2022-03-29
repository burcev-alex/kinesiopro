@if(isset($pagination) && ($pagination['prev_url'] || $pagination['next_url']))
    @if($pagination['next_url'])
        <a href="{{$pagination['next_url']}}" class="loadBtn flex" data-action="async" data-block="{{$block ?? 'default'}}">
            <span>{{__('product.load_more')}}</span>
        </a>
    @endif
@endif
