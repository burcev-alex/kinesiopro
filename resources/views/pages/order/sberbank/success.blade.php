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
            @php
                echo '<pre>'.print_r($data, true).'</pre>';
            @endphp
        </div>
    </div>
    <p>Order success</p>
@endsection
