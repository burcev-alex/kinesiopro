@isset($media)
    <div class="img-block single-item">
        <img class="img-gif" src="{{ $media[0]->url() }}" alt="">
    </div>
@endisset
