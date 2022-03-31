@extends('layouts.app')

@section('metaLabels')
    @parent
    @include('meta::manager', [
        'title' => __('product.checkout.title'),
        'description' => '',
    ])
@stop

@section('content')
    <div class="cart-block">
        <div id="emptyCart" @if (!empty($data)) hidden="hidden" @endif>
            {{ __('product.cart.empty') }}
        </div>
    </div>
@endsection