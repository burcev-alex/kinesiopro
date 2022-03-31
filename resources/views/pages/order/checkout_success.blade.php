@extends('layouts.app')

@section('metaLabels')
    @parent
    @include('meta::manager', [
        'title' => __('product.checkout.title'),
        'description' => '',
    ])
@stop

@section('content')
    <div class="container">
        <div class="breadCrumbs">
            <a href="" class="backBtn">
                <svg>
                    <use xlink:href="/img/icons/svgSprite.svg#arrLeft"></use>
                </svg>
            </a>
            <p class="breadCrumbs__name">{{ __('product.checkout.title') }}</p>
        </div>
    </div>
    {{-- VUE --}}
    <p>Order success</p>
@endsection
