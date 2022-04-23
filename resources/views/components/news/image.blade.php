@if (is_array($media) && $media)
    @foreach ($media as $photo)
        @if ($photo)
            @php
                if(substr_count($photo->url(), '.png') > 0){
                    $link = $photo->url();
                }
                else{
                    $link = str_replace(['/storage/', '.jpg', '.jpeg', '.png'], ['/storage/webp/', '.webp', '.webp', '.webp'], $photo->url());
                }
            @endphp
            <div class="img-block single-item">
                <img src="{{ $link }}" alt="{{ $photo->original_name }}">
            </div>
        @endif
    @endforeach

@endif
