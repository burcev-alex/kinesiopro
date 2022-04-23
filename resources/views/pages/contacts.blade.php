@extends('layouts.app')

@section('metaLabels')
    @parent
    @include('meta::manager', [
    'title' => "Контакты",
    'keywords' => "",
    'description' => ""
    ])
@stop

@section('content')
    @include('includes.partials.breadcrumbs')
    
    <h1 class="width titleH1">Контакты</h1>

    <section class="contacts width">
        <ul class="contactsList flex">
            @foreach ($items as $item)
            <li>
                <h2 class="contactsBlock__title">{{ $item->city }}</h2>

                <div class="contactsBlock">
                    @if($item->url)
                        <a href="{{ $item->url }}" class="contactsBlock__href">{{ $item->url }}</a>
                    @endif

                    @if($item->full_name)
                    <b class="contactsBlock__name">{{ $item->full_name }}</b>
                    @endif

                    @if($item->address)
                        <address>Адрес: {{ $item->address }}</address>
                    @endif

                    <a href="mailto:{{ $item->email }}" class="contactsBlock__mail">Email: <span>{{ $item->email }}</span></a>
                    
                    @if($item->phone && is_array($item->phone))
                    <ul class="contactsBlockList flex">
                        <li>
                            <span>Тел:</span>
                        </li>
                        @foreach ($item->phone as $key=>$phone)
                            <li>
                                <a href="tel:{{ $phone }}">{{ $phone }}@if(($key+1) != count($item->phone)), @endif</a>
                            </li>
                        @endforeach
                    </ul>
                    @endif

                    <ul class="contactsListSocial flex">
                        @if(strlen($item->fb) > 0)
                        <li>
                            <a href="{{ $item->fb }}">
                                <img src="/images/icon32.svg" alt="">
                            </a>
                        </li>
                        @endif

                        @if(strlen($item->vk) > 0)
                        <li>
                            <a href="{{ $item->vk }}">
                                <img src="/images/icon33.svg" alt="">
                            </a>
                        </li>
                        @endif

                        @if(strlen($item->instagram) > 0)
                        <li>
                            <a href="{{ $item->instagram }}">
                                <img src="/images/icon34.svg" alt="">
                            </a>
                        </li>
                        @endif

                        @if(strlen($item->youtube) > 0)
                        <li>
                            <a href="{{ $item->youtube }}">
                                <img src="/images/icon35.svg" alt="">
                            </a>
                        </li>
                        @endif
                    </ul>
                </div>
            </li>
            @endforeach
        </ul>
    </section>
@endsection