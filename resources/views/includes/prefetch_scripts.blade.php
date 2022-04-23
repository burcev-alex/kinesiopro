@foreach ($list as $path)
    <link rel="prefetch" href="{{ $path }}" as="script" />
@endforeach