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
                    @if(strlen($banner['time_organization']) > 0)
                        <div class="sliderTopText__date">{{ $banner['time_organization'] }}</div>
                    @endif

                    <h2 class="sliderTopText__title">{{ $banner['name'] }}</h2>

                    @if(strlen($banner['place']) > 0)
                        <span class="sliderTopText__bg">{{ $banner['place'] }}</span>
                    @endif

                    @if(strlen($banner['description']) > 0)
                        <p class="sliderTopText__paragraf">{{ $banner['description'] }}</p>
                    @endif
                </div>
            </div>
        </div>
    @endforeach
</div>
