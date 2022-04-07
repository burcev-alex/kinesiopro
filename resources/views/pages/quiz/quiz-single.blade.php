@extends('layouts.app')


@section('metaLabels')
    @parent
    @include('meta::manager', [
    'title' => $quiz_item->meta_title,
    "description" => $quiz_item->meta_description
    ])
@stop

@section('content')
    @include('includes.partials.breadcrumbs')
    <h1 class="width titleH1">{{ $quiz_item->title }}</h1>

    <div class="testIn width flex">
        <img src="{{ $quiz_item->banner != null ? $quiz_item->banner->url() : '' }}" alt="">

        <div class="testInRight">{!! $quiz_item->description !!}</div>
    </div>

    <section class="teachers intensive" data-block="tests-intensive">
        @foreach ($components as $key=>$component)
            <div class="teachersIn width" id="anchor{{ $key }}" data-number="{{ $key + 1 }}" style="display:none;">
            @switch($component->slug)
                @case('element-comment')
                    <x-quiz.element-comment :number="$key" :fields="$component->mediaFields" />
                @break
                @case('simple-element')
                    <x-quiz.simple-element :number="$key" :fields="$component->mediaFields" />
                @break
                @default

            @endswitch
            </div>
        @endforeach
        
        <div id="total" class="width" style="display: none;">
            <hr>
            <h2>Итог: <span class="subtotal">0</span>%</h2>
        </div>
    </section>
@stop

@push('after-scripts')
    @include('includes.scripts', [
    'list' => [
        mix('js/quiz_page_script.js')
    ],
    ])
@endpush
