import { Pagination } from './modules/pagination';
import { Checkout } from './modules/checkout';

$(document).ready(function () {
    let pagination = new Pagination();
    
    let checkout = new Checkout();

    $('#phone').mask('+7 (999) 999-99-99');
});







