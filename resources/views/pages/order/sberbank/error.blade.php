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
        <img src="/images/icon43.svg" alt="">

        <div class="orderContent flex">
            <span>К сожалению в процессе оплаты произошла ошибка</span>
            <a href="{{ route('profile.index') }}">Вернуться в личный кабинет</a>
        </div>
    </div>
@endsection
