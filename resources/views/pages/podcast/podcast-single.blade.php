@extends('layouts.app')


@section('metaLabels')
    @parent
    @include('meta::manager', [
    'title' => $podcast->meta_title,
    'keywords' => $podcast->meta_keywords,
    "description" => $podcast->meta_description
    ])
@stop

@section('content')
    @include('includes.partials.breadcrumbs')
    <h1 class="width titleH1">{{ $podcast->title }}</h1>

    <main class="mainContent width flex">
        <div class="mainRight">
            <div class="mainBlock">
                @if($podcast->url)
                <div>
                    <div id="vk_podcast" style="width: 100%; height: 152px;"></div>
                </div>
                @endif
                <div class="paragraf"> {!! $podcast->description !!} </div>
            </div>
        </div>
    </main>
    @if($podcast->url)
        <script type="text/javascript">
        window.podcastIdentifMark = "{{ $podcast->identif_mark }}";
        </script>
    @endif

@stop


@push('after-scripts')
    @include('includes.scripts', [
    'list' => [
        'https://vk.com/js/api/openapi.js?169',
        mix('js/podcast_page_script.js')
    ],
    ])
@endpush