import { Filter } from './modules/filter';
import { initSlider } from './modules/slider';

$(document).ready(function () {
    let filter = new Filter('home-page-block-course');
    filter.init();
    filter.firstLoad();

    initSlider($('.itemSlider'));

    $('.sliderTop').slick({
        slidesToShow: 1,
        dots: true
    });
});







