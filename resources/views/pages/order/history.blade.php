@extends('layouts.app')

@section('metaLabels')
    @parent
    @include('meta::manager', [
        'title' => __('history.title'),
        'description' => '',
    ])
@stop

@section('content')
    <div class="user-page-wrapper">
        @include('includes.breadcrumbs')
        
        <div class="content">
            <div class="order-history-wrapper">
                @foreach ($items as $order)
                    @include('includes.userInfo.history_item', ['order' => $order])
                @endforeach
            </div>
        </div>
    </div>
@endsection

@push('after-scripts')
    @include('includes.scripts', ['list' => [ mix('js/history_page_script.js')]])
@endpush