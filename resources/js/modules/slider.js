//init slider
export function initSlider(containers) {
    containers.each(function(){
        if(!$(this).hasClass('slick-initialized')){
            $(this).slick({
                slidesToShow: 3,
                dots: false,
                infinite: false,
                prevArrow: "<img src='/images/icon24.svg' class='prev' alt='1'>",
                nextArrow: "<img src='/images/icon25.svg' class='next' alt='2'>",
                responsive: [{
                        breakpoint: 781,
                        settings: {
                            slidesToShow: 2,
                            slidesToScroll: 1
                        }
                    },
                    {
                        breakpoint: 581,
                        settings: {
                            slidesToShow: 1,
                            slidesToScroll: 1
                        }
                    },
                ]
            })
        }
    });
}