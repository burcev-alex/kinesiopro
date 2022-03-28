import { Schedule } from './modules/schedule';

$(document).ready(function () {
    let schedule = new Schedule();
    schedule.init();

    $('.itemSlider').slick({
        slidesToShow: 3,
        dots: false,
        prevArrow: "<img src='/images/icon24.svg' class='prev' alt='1'>",
        nextArrow: "<img src='/images/icon25.svg' class='next' alt='2'>",
        responsive: [{
                breakpoint: 781,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 1,
                }
            },

            {
                breakpoint: 581,
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1,
                }
            },
        ]
    });

    $('.sliderTop').slick({
        slidesToShow: 1,
        dots: true
    });
});







