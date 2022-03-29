<div class="push"></div>

<!--Start footer-->
<footer class="footer">
    <div class="footerIn flex width">
        <div class="footerBlock">
            <a href="{{ route('index') }}" class="footerBlock__Logo">
                <img src="/images/footerLogo.svg" alt="">
            </a>

            <a href="tel:+7 (925) 038-61-32" class="footerBlock__phone">+7 (925) 038-61-32</a>
            <a href="mailto:kineziopro@gmail.com" class="footerBlock__mail"><span>kineziopro@gmail.com</span></a>

            <a href="#" class="perAccount flex">
                <span>Личный кабинет</span>
            </a>

            <ul class="footerSocial flex">
                <li>
                    <a href="#">
                        <img src="/images/icon.svg" alt="">
                    </a>
                </li>

                <li>
                    <a href="https://vk.com/physiosapiens" target="_blank">
                        <img src="/images/icon2.svg" alt="">
                    </a>
                </li>

                <li>
                    <a href="#">
                        <img src="/images/icon3.svg" alt="">
                    </a>
                </li>

                <li>
                    <a href="https://www.youtube.com/channel/UCsxUk35UDtUY4d-6pF0E__A" target="_blank">
                        <img src="/images/icon4.svg" alt="">
                    </a>
                </li>
            </ul>
        </div>

        @if(count($categories) > 0)
        <div class="footerBlockList">
            <h3 class="footerH3">Концепции физической реабилитации</h3>

            <ul class="footerBlockListMenu">
                @foreach ($categories as $category)
                    <li>
                        <a href="{{ route('courses.index', [$category['slug']]) }}">{{ $category['name'] }}</a>
                    </li>
                @endforeach

            </ul>
        </div>
        @endif
        
        @if(count($articles) > 0)
        <div class="footerBlockList2">
            <h3 class="footerH3">Свежие записи <br> в блоге</h3>

            <div class="footerBlockIn flex">
                @foreach ($articles->chunk(3) as $chunk=>$chunkItems)
                    <ul class="footerBlockListMenu footerBlockListMenu{{ $chunk+2 }}">
                        @foreach ($chunkItems as $article)
                            <li>
                                <a href="{{ route('blog.single', ['slug' => $article->slug]) }}">{{ $article->title }}</a>
                            </li>
                        @endforeach
                    </ul>
                @endforeach
            </div>
        </div>
        @endif
    </div>
</footer>
<!--Start footer-->
