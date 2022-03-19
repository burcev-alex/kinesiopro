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
            ->image(config('app.url').'/images/tild6230-3961-4661-b731-626539626362__-2-01.png')
            ->url(config('app.url'))
            ->telephone("0800-755-667")
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

    {{-- <link rel="shortcut icon" href="{{ mix('images/tild3530-3830-4238-a131-633239336535__favicon.ico') }}" type="image/x-icon" /> --}}

    <link href="{{ mix('css/app.css') }}" media="all" type="text/css" rel="stylesheet">

    <script type="text/javascript">
        window.dataLayer = window.dataLayer || [];
    </script>
    
    @stack('after-styles')
</head>
<body>
    @yield('content')

    <script>
        window._defaultLocale = '{{ config('app.locale') }}';
        window._locale = '{{ app()->getLocale() }}';
        window._translations = {!! cache('translations') !!};
    </script>
    @stack('before-scripts')
        <script src="{{ mix('js/main_script.js') }}"></script>
    @stack('after-scripts')
</body>
</html>
