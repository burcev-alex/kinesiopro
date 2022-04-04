import { Filter } from './modules/filter';
import { Pagination } from './modules/pagination';
import { initSlider } from './modules/slider';
import { Checkout } from './modules/checkout';

$(document).ready(function () {
    let filter = new Filter('course-grid-block');
    filter.setIsCatalog();
    filter.setLimitPage(10);
    filter.init();

    let pagination = new Pagination();
    
    let checkout = new Checkout();

    $('#phone').mask('+7 (999) 999-99-99');

    initSlider($('.itemSlider'));
});







