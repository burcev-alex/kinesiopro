import { Filter } from './modules/filter';

$(document).ready(function () {
    let filter = new Filter('home-page-block-course');
    filter.setLimitPage(3);
    filter.init();
    filter.firstLoad();
});







