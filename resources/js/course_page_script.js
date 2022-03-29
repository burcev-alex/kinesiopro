import { Filter } from './modules/filter';
import { Pagination } from './modules/pagination';
import { initSlider } from './modules/slider';

$(document).ready(function () {
    let filter = new Filter('course-grid-block');
    filter.setIsCatalog();
    filter.setLimitPage(10);
    filter.init();

    let pagination = new Pagination();

    initSlider($('.itemSlider'));
});







