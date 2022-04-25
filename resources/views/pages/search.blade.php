@extends('layouts.app')

@section('metaLabels')
    @parent
    @includeIf('meta::manager', [
        'title' => 'Поиск',
        'description' => '',
    ])
@stop

@section('content')
    @include('includes.partials.breadcrumbs')

    <h1 class="width titleH1 titleH12">Поиск</h1>

    <!--Start search-->
    <section class="search width">
        <form action="{{ route('search') }}" method="get" class="searchForm">
            <input placeholder="Поиск" name="q" value="{{ $q }}" type="text">
            <button type="submit" class="searchForm__btn"></button>
        </form>

        @if(strlen($q) > 0)
            <div class="searchtext">Результаты поиска по запросу 
                <span class="searchtext__word">{{ $q }}</span>, найдено
                <span>{{ count($items) }}</span>
                совпадений:
            </div>

            @if(count($items) > 0)
            <div class="searchRezults">
                @foreach ($items as $item)
                    <div class="searchRezultsItem">
                        <p>{!! $item['content'] !!}</p>
                        <a href="{{ $item['url'] }}">Подробнее</a>
                    </div>
                @endforeach
            </div>
            @endif
        @endif
    </section>
    <!-- End search -->
@endsection
