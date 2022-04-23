@if (Breadcrumbs::has() && !Route::is('frontend.index'))
    <!--Start bread-->
    <div class="width flex bread" id="breadcrumbs" aria-label="breadcrumb">
        <ul class="bread-crumbs">
            <li>
                <a href="{{ route('index') }}"><span>{{ __('breadcrumbs.home') }}</span></a>
            </li>
            @foreach (Breadcrumbs::current() as $crumb)
                @if ($crumb->url() && !$loop->last)
                    <li>
                        <a href="{{ $crumb->url() }}"><span>{{ $crumb->title() }}</span></a>
                    </li>
                @else
                    <li aria-current="page">
                        <span>{{ $crumb->title() }}</span>
                    </li>
                @endif
            @endforeach
        </ul>
    </div>
    <!--End bread-->

    @php
        $listItems = [];
        foreach(Breadcrumbs::current() as $i=>$crumbs){
            $listItems[] = \Spatie\SchemaOrg\Schema::listItem()
                ->position($i)
                ->name($crumbs->title())
                ->item($crumbs->url());
        }
        echo \Spatie\SchemaOrg\Schema::breadcrumbList()->itemListElement($listItems)->toScript();
    @endphp
@endif