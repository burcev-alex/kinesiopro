@extends('layouts.app')

@section('metaLabels')
    @parent
    @includeIf('meta::manager', [
        'title' => __('main.meta.video_title'),
        'description' => __('main.meta.video_description')
    ])
@stop

@section('content')
    @include('includes.partials.breadcrumbs')
    <h1 class="width titleH1">{{ __('main.meta.video_h1') }}</h1>

    <!-- Start videoContent-->
    <div class="video width">
        <div class="videoContent flex" id="video-grid-block">
            @include('includes.video.grid', ['articles' => $articles])
        </div>
        
        <div class="pagination-block">
            @include('includes.pagination', ['block' => 'video-grid-block'])
        </div>
    </div>
    <!-- End videoContent-->
@endsection

@push('after-scripts')
    @include('includes.scripts', [
    'list' => [
        mix('js/video_page_script.js')
    ],
    ])
@endpush