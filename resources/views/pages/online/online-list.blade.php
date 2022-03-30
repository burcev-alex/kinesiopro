@extends('layouts.app')

@section('metaLabels')
    @parent
    @includeIf('meta::manager', [
        'title' => __('main.meta.online_title'),
        'description' => __('main.meta.online_description')
    ])
@stop

@section('content')
    @include('includes.partials.breadcrumbs')
    <h1 class="width titleH1">{{ __('main.meta.online_h1') }}</h1>

    <!-- Start onlineContent-->
    <ul class="blogItem flex onlineContent width" id="online-grid-block">
        @include('includes.online.grid', ['onlines' => $onlines])
    </ul>
    
    <div class="pagination-block">
        @include('includes.pagination', ['block' => 'online-grid-block'])
    </div>
    <!-- End onlineContent-->
@endsection

@push('after-scripts')
    @include('includes.scripts', [
    'list' => [
        mix('js/online_page_script.js')
    ],
    ])
@endpush