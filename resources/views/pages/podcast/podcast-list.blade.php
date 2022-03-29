@extends('layouts.app')

@section('metaLabels')
    @parent
    @includeIf('meta::manager', [
        'title' => __('main.meta.podcast_title'),
        'description' => __('main.meta.podcast_description')
    ])
@stop

@section('content')
    @include('includes.partials.breadcrumbs')
    <h1 class="width titleH1">{{ __('main.meta.podcast_h1') }}</h1>

    <!-- Start podcastContent-->
    <ul class="blogItem flex podcast width" id="podcast-grid-block">
        @include('includes.podcast.grid', ['podcasts' => $podcasts])
    </ul>
    
    <div class="pagination-block">
        @include('includes.pagination', ['block' => 'podcast-grid-block'])
    </div>
    <!-- End podcastContent-->
@endsection

@push('after-scripts')
    @include('includes.scripts', [
    'list' => [
        mix('js/podcast_page_script.js')
    ],
    ])
@endpush