<div class="slider sliderTop width">
    @foreach ($banners as $banner)
        @if (!$banner)
            @continue
        @endif
        <div>
            <div class="sliderTopContent">
                @desktop
                <img src="{{ $banner['image_webp'] }}" alt="{{ $banner['name'] }}" class="sliderTop__desctop">
                @enddesktop
                
                @mobile
                <img src="{{ $banner['image_mobile'] }}" alt="{{ $banner['name'] }}" class="sliderTop__mobil">
                @endmobile

                <div class="sliderTopText">
                    <div class="sliderTopText__date">24-26 ноября</div>
                    <h2 class="sliderTopText__title">{{ $banner['name'] }}</h2>
                    <span class="sliderTopText__bg">Scolio Russia</span>
                    <p class="sliderTopText__paragraf">Лучшие спикеры России и Европы</p>
                </div>
            </div>
        </div>
    @endforeach
</div>
