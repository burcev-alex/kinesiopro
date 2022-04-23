@extends('layouts.app')

@section('metaLabels')
    @parent
    @includeIf('meta::manager', [
        'title' => __('main.meta.teacher_title'),
        'description' => __('main.meta.teacher_description')
    ])
@stop

@section('content')
    @include('includes.partials.breadcrumbs')
    <h1 class="width titleH1">{{ __('main.meta.teacher_h1') }}</h1>

    <!--Start mainContent-->
    <main class="mainContent width">
        <div class="flex" id="teacher-grid-block">
            @include('includes.teacher.grid', ['teachers' => $teachers])
        </div>
    </main>
    <!-- End teacherContent-->
@endsection