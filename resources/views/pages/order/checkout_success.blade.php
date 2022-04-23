@extends('layouts.app')

@section('metaLabels')
    @parent
    @include('meta::manager', [
        'title' => __('product.checkout.title'),
        'description' => '',
    ])
@stop

@section('content')
    @include('includes.partials.breadcrumbs')
        
    <h1 class="width titleH1">Заказ</h1>
    <div class="order width flex">
        <img src="/images/icon42.svg" alt="">

        <div class="orderContent flex">
            <span>Спасибо, ваш заказ принят и успешно оплачен!</span>
            <a href="{{ route('profile.index') }}">Вернутсья в личный кабинет</a>
        </div>
    </div>
@endsection
