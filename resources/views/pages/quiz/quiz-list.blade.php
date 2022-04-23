@extends('layouts.app')

@section('metaLabels')
    @parent
    @includeIf('meta::manager', [
        'title' => __('main.meta.quiz_title'),
        'description' => __('main.meta.quiz_description')
    ])
@stop

@section('content')
    @include('includes.partials.breadcrumbs')
    <h1 class="width titleH1">{{ __('main.meta.quiz_h1') }}</h1>

    <!-- Start quizContent-->
    <div class="width">
        <ul class="blogItem flex testContent" id="quiz-grid-block">
            @include('includes.quiz.grid', ['articles' => $articles])
        </ul>
        
        <div class="pagination-block">
            @include('includes.pagination', ['block' => 'quiz-grid-block'])
        </div>
    </div>
    <!-- End quizContent-->
@endsection

@push('after-scripts')
    @include('includes.scripts', [
    'list' => [
        mix('js/quiz_page_script.js')
    ],
    ])
@endpush