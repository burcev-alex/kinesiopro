@extends('layouts.app')

@section('metaLabels')
    @parent
    @includeIf('meta::manager', [
        'title' => strlen($meta['meta_title'])>0 ? $meta['meta_title'] : __('main.meta.blog_title'),
        'description' => strlen($meta['meta_description'])>0 ? $meta['meta_description'] : __('main.meta.blog_description')
    ])
@stop

@section('content')
    @include('includes.partials.breadcrumbs')
    <h1 class="width titleH1">{{ strlen($meta['meta_h1']) > 0 ? $meta['meta_h1'] : __('main.meta.blog_h1') }}</h1>

    <!-- Start blogContent-->
    <section class="blogContent width blog-container">
        <ul class="blogItem flex" id="blog-grid-block">
            @include('includes.blog.items', ['articles' => $articles])
        </ul>
        
        <div class="pagination-block">
            @include('includes.pagination', ['block' => 'blog-grid-block'])
        </div>
    </section>
    <!-- End blogContent-->
@endsection

@push('after-scripts')
    @include('includes.scripts', [
    'list' => [
        mix('js/blog_page_script.js')
    ],
    ])
@endpush