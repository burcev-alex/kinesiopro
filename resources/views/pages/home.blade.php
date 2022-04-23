@extends('layouts.app')

@section('metaLabels')
    @parent
    @include('meta::manager', [
    'title' => "KinesioPro | Официальные курсы Maitland, PNF, Bobath, CIMT, SEAS, Нейродинамика",
    'description' => "Курсы физической реабилитации, мануальной терапии и лечебной физкультуры. Кинезио (кинезитерапия, кинезиотерапия, кинезотерапия)"
    ])
@stop

@push('before-styles')
    <link href="{{ mix('css/slick.css') }}" media="all" type="text/css" rel="stylesheet">
@endpush


@section('content')
    @include('includes.home.banners')
    
    @include('includes.home.service')

    <script language="JavaScript">
        window.filterParams = {};
    </script>
    @include('includes.home.schedule', [
        'fieldsFilter' => [
            'city' => true,
            'format' => true,
            'teacher' => true,
            'period' => true,
            'direct' => false,
        ]
    ])

@endsection

@push('before-scripts')
    @include('includes.scripts', [
    'list' => [
        mix('js/plugins/slick.js')
    ],
    ])
@endpush

@push('after-scripts')
    @include('includes.scripts', [
    'list' => [
        mix('js/main_page_script.js')
    ],
    ])
@endpush
