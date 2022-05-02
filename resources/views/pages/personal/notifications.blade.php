@extends('layouts.app')

@section('metaLabels')
    @parent
    @include('meta::manager', [
        'title' => __('breadcrumbs.personal.profile'),
    ])
@stop

@section('content')
    @include('includes.partials.breadcrumbs')

    <h1 class="width titleH1">Личные уведомления</h1>

    <!-- Start accountContent -->
    <section class="accountContent width flex">
        <div class="accountLeft">
            @include('includes.personal.sidebar', [
                'title' => 'Уведомления',
            ])
        </div>

        <div class="accountCenter">
            <h3 class="accountCenter__title">Уведомления</h3>


            <ul class="width listPodcast">
                @foreach ($logged_in_user->notifications as $notify)
                    <li>
                        <div class="listPodcast__date flex">
                            <span>{{ $notify->created_at->format('d') }}</span>
                            <span>{{ $notify->created_at->translatedFormat('M') }}</span>
                        </div>

                        <a href="{{ route('orders.index') }}">
                            {{ $notify->data['title'] }}:
                            @if ($notify->data['type'] == 'online')
                                {{ $notify->data['online']['title'] }}
                            @endif
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>

    </section>
    <!-- End accountContent -->

@endsection

@push('after-scripts')
    @include('includes.scripts', [
        'list' => ['/js/profile_page_script.js'],
    ])
@endpush
