@extends('layouts.app')

@section('metaLabels')
    @parent
    @include('meta::manager', [
        'title' => __('history.title'),
        'description' => '',
    ])
@stop

@section('content')
    @include('includes.partials.breadcrumbs')
            
    <h1 class="width titleH1">Покупки</h1>

    <!-- Start accountContent -->
    <section class="accountContent width flex">
        <div class="accountLeft">
            @include('includes.personal.sidebar')
        </div>

        <div class="buyAccount">
            <h3 class="accountCenter__title">{{ $typeTitle }}</h3>

            <ul class="tables flex">
                <li class="tables__header">
                    <span class="tables__num">№</span>
                    <span class="tables__date">Дата</span>
                    <span class="tables__title">Название продукта</span>
                    <span class="tables__price">Стоимость</span>
                    <span class="tables__status">Статус</span>
                </li>
                @foreach($items as $order)
                    <li class="tablesBody">
                        <span class="tablesBody__num">{{ $loop->index + 1 }}</span>
                        <span class="tablesBody__date">{{ $order['created_at'] }}</span>
            
                        <div class="tablesBody__title flex">
                            <div class="tablesBody__left">
                                <div class="tablesBody__top">
                                    @php
                                        $product = current($order['items']);
                                    @endphp
                                    @if(count($order['stream']) == 0)
                                        {{ $product['name'] }}
                                    @else 
                                        <a href="{{ route('stream.single', ['slug' => $order['stream']['slug']]) }}">{{ $product['name'] }}</a>
                                    @endif
                                    <span class="tablesBody__topDot">...</span>
                                    <span class="tablesBody__bold">{{ $order['total'] }} руб.</span></div>
            
                                <ul class="tablesBodyList">
                                    <li class="tablesBodyList__bold">
                                        <b class="tablesBodyList__name">Общая стоимость</b>
                                        <b class="tablesBodyList__price">{{ $order['total'] }} р.</b>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        @if($order['payment_status'] == 'waiting')
                            <a href="{{ array_key_exists('url', $order['payment']) ? $order['payment']['url'] : '#' }}" target="_blank" class="tablesBody__processing {{ $order['stateClass'] }}">{{ $order['stateTitle'] }}</a>
                        @else
                            <span class="tablesBody__processing {{ $order['stateClass'] }}">{{ $order['stateTitle'] }}</span>
                        @endif
                        <span class="tablesBody__btn"></span>
                    </li>
                @endforeach
            </ul>
        </div>

    </section>
    <!-- End accountContent -->
   
@endsection

@push('after-scripts')
    @include('includes.scripts', [
    'list' => [
        '/js/profile_page_script.js'
    ],
    ])
@endpush