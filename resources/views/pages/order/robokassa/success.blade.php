@extends('layouts.app')

@section('metaLabels')
    @parent
    @include('meta::manager', [
        'title' => __('product.checkout.title'),
        'description' => '',
    ])
@stop

@section('content')
    </div>
    <p>Order success</p>
@endsection
