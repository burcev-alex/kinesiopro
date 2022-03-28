<!doctype html>
<html lang="{{ htmlLang() }}" @langrtl dir="rtl" @endlangrtl>
<head>
    @section('metaLabels')
        <meta charset="utf-8">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        
        <meta name="format-detection" content="telephone=no" />
        <meta http-equiv="x-dns-prefetch-control" content="on">
        
        <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
        <meta http-equiv="Pragma" content="no-cache" />
        <meta http-equiv="Expires" content="0" />
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta content="IE=edge" http-equiv="X-UA-Compatible">
        <link rel="canonical" href="https://kinesiopro.ru/">

        @if (config('app.env') == 'local')
            <meta name="googlebot" content="noindex, nofollow"/>
            <meta name="yandex" content="none"/>
        @else
            <meta name="robots" content="all" />
        @endif

        @yield('meta')

        
    @show
    
    @section('scheme')
        @php
        echo \Spatie\SchemaOrg\Schema::localBusiness()
            ->name(config('app.name'))
            ->image(config('app.url').'/images/headerLogo.svg')
            ->url(config('app.url'))
            ->telephone("+7 (925) 038-61-32")
            ->address(\Spatie\SchemaOrg\Schema::postalAddress()
                ->streetAddress("Самарская,2/3")
                ->addressLocality("Одесса")
                ->postalCode('75410')
                ->addressCountry('UA')
            )
            ->openingHoursSpecification(\Spatie\SchemaOrg\Schema::openingHoursSpecification()
                ->dayOfWeek([
                    "Monday",
                    "Tuesday",
                    "Wednesday",
                    "Thursday",
                    "Friday",
                    "Saturday",
                    "Sunday"
                ])
                ->opens("00:00")
                ->closes('23:59')
            )
            ->sameAs([
                "https://www.facebook.com/kinesiopro.ru/",
                "https://www.instagram.com/kinesiopro.ru/",
            ])->toScript();
        @endphp
    @show


    @stack('before-styles')
    
    <!-- Assets -->
    <link href="{{ mix('css/selects.css') }}" media="all" type="text/css" rel="stylesheet">
    <link href="{{ mix('css/app.css') }}" media="all" type="text/css" rel="stylesheet">

    <script type="text/javascript">
        window.dataLayer = window.dataLayer || [];
    </script>
    
    @stack('after-styles')
</head>
<body>
    <div class="wrapper" id="app">
        @include('includes.header')
    
        @yield('content')

        @include('includes.footer')
    </div>

    <script>
        window._defaultLocale = '{{ config('app.locale') }}';
        window._locale = '{{ app()->getLocale() }}';
        window._translations = {!! cache('translations') !!};
    </script>
    
    <script src="{{ mix('js/plugins/jquery.min.js') }}"></script>
    @stack('before-scripts')
        <script src="{{ mix('js/plugins/selects.js') }}"></script>
        <script src="{{ mix('js/main_script.js') }}"></script>
    @stack('after-scripts')
</body>
</html>
