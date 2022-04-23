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

    <ul class="scheduleList flex">
        <li>
            <a @if($type == 'grid') href="javascript:;" class="active" @else href="{{ route('podcast') }}?view=grid" data-action="change_view" data-value="grid" data-entity="podcast" @endif>Плитка</a>
        </li>

        <li>
            <div class="scheduleSlider @if($type == 'list') offline @endif ">
                <span class="scheduleSlider__btn"></span>
            </div>
        </li>

        <li>
            <a @if($type == 'list') href="javascript:;" class="active" @else href="{{ route('podcast') }}?view=list" data-action="change_view" data-value="list" data-entity="podcast" @endif>Список</a>
        </li>
    </ul>
    
    <!-- Start podcastContent-->
    <ul class="width @if($type == 'grid') blogItem flex podcast @else listPodcast @endif" id="podcast-grid-block">
        @include('includes.podcast.'.$type, ['podcasts' => $podcasts])
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