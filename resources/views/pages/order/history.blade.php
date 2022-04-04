@extends('layouts.app')

@section('metaLabels')
    @parent
    @include('meta::manager', [
        'title' => __('history.title'),
        'description' => '',
    ])
@stop

@section('content')
    
    @dd($items);
@endsection