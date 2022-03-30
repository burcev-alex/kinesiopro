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

        <meta name="mobile-web-app-capable" content="yes">
        <meta name="apple-mobile-web-app-capable" content="yes">
        <meta name="apple-mobile-web-app-status-bar-style" content="#555">
        <link href="/favicon.ico" rel="apple-touch-icon">
        <link href="/favicon.ico" rel="apple-touch-icon" sizes="76x76">
        <link href="/favicon.ico" rel="apple-touch-icon" sizes="120x120">
        <link href="/favicon.ico" rel="apple-touch-icon" sizes="152x152">

        <link rel="icon" type="image/png" href="/favicon.ico">
        <link rel="profile" href="https://gmpg.org/xfn/11">

        @yield('meta')

        @if (config('app.env') == 'local')
            <meta name="googlebot" content="noindex, nofollow"/>
            <meta name="yandex" content="none"/>
        @else
            <meta name="robots" content="all" />
        @endif
        
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
    <link href="{{ mix('css/app.css') }}" media="all" type="text/css" rel="stylesheet">
    <link href="{{ mix('css/selects.css') }}" media="all" type="text/css" rel="stylesheet">

    
    
    @stack('after-styles')

    @if (config('app.env') == 'production')
        <script type="text/javascript" async="" src="https://www.google-analytics.com/analytics.js"></script>
        <!-- Global site tag (gtag.js) - Google Analytics -->
        <script async="" src="https://www.googletagmanager.com/gtag/js?id=UA-34398190-3"></script>
        <script>
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());
            gtag('config', 'UA-34398190-3');
        </script>
        <script type="text/javascript">
            window.dataLayer = window.dataLayer || [];
            let targetEvent = {};
            (function(m,e,t,r,i,k,a){m[i]=m[i]||function(){(m[i].a=m[i].a||[]).push(arguments)};
                m[i].l=1*new Date();k=e.createElement(t),a=e.getElementsByTagName(t)[0],k.async=1,k.src=r,a.parentNode.insertBefore(k,a)})
            (window, document, "script", "https://mc.yandex.ru/metrika/tag.js", "ym");
    
            ym(33398688, "init", {
                clickmap:true,
                trackLinks:true,
                accurateTrackBounce:true,
                webvisor:true,
                ecommerce:"dataLayer"
            });
        </script>

        <!-- VK Pixel -->
        <script type="text/javascript">!function(){var t=document.createElement("script");t.type="text/javascript",t.async=!0,t.src="https://vk.com/js/api/openapi.js?167",t.onload=function(){VK.Retargeting.Init("VK-RTRG-465569-ckDbP"),VK.Retargeting.Hit()},document.head.appendChild(t)}();</script>
        <script type="text/javascript" async="" src="https://vk.com/js/api/openapi.js?167"></script>
        <noscript><img src="https://vk.com/rtrg?p=VK-RTRG-465569-ckDbP" style="position:fixed; left:-999px;" alt=""/></noscript>
        <!-- /VK Pixel -->

        <script async="" src="https://connect.facebook.net/en_US/fbevents.js"></script>
        <script async="" src="https://mc.yandex.ru/metrika/tag.js"></script>

        <script type="text/javascript">
            window.dataLayer = window.dataLayer || [];
            let targetEvent = {};
            (function(m,e,t,r,i,k,a){m[i]=m[i]||function(){(m[i].a=m[i].a||[]).push(arguments)};
                m[i].l=1*new Date();k=e.createElement(t),a=e.getElementsByTagName(t)[0],k.async=1,k.src=r,a.parentNode.insertBefore(k,a)})
            (window, document, "script", "https://mc.yandex.ru/metrika/tag.js", "ym");
    
            ym(33398688, "init", {
                clickmap:true,
                trackLinks:true,
                accurateTrackBounce:true,
                webvisor:true,
                ecommerce:"dataLayer"
            });
        </script>
    @endif
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

    @if (config('app.env') == 'production')
        <!--LiveInternet counter-->
        <script type="text/javascript">
            new Image().src = "//counter.yadro.ru/hit?r"+
            escape(document.referrer)+((typeof(screen)=="undefined")?"":
            ";s"+screen.width+"*"+screen.height+"*"+(screen.colorDepth?
            screen.colorDepth:screen.pixelDepth))+";u"+escape(document.URL)+
            ";h"+escape(document.title.substring(0,150))+
            ";"+Math.random();</script>
        <!--/LiveInternet-->
        <!-- Facebook Pixel Code -->
        <script>
            !function(f,b,e,v,n,t,s)
            {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
                n.callMethod.apply(n,arguments):n.queue.push(arguments)};
                if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
                n.queue=[];t=b.createElement(e);t.async=!0;
                t.src=v;s=b.getElementsByTagName(e)[0];
                s.parentNode.insertBefore(t,s)}(window, document,'script',
                'https://connect.facebook.net/en_US/fbevents.js');
            fbq('init', '593893420750108');
            fbq('track', 'PageView');
        </script>
        <noscript><img height="1" width="1" style="display:none" alt="fbpixel"
            src="https://www.facebook.com/tr?id=593893420750108&ev=PageView&noscript=1"
 /></noscript>
 <!-- End Facebook Pixel Code -->
    @endif
    
    <script src="{{ mix('js/plugins/jquery.min.js') }}"></script>
    <script src="{{ mix('js/plugins/jquery.validate.min.js') }}"></script>
    @stack('before-scripts')
        <script src="{{ mix('js/plugins/selects.js') }}"></script>
        <script src="{{ mix('js/main_script.js') }}"></script>
    @stack('after-scripts')
</body>
</html>
