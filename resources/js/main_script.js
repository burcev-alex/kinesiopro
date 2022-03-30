window.axios = require('axios');
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
window.axios.defaults.headers.common['x-apikey'] = '123456';


let langPrefix = $('html').attr('lang') === 'ru' ? '/ru' : '';
let token = $('meta[name="csrf-token"]').attr('content');

require('./modules/validator');

let isMobile;
if (/Android|webOS|iPhone|iPad|iPod|BlackBerry|BB|PlayBook|IEMobile|Windows Phone|Kindle|Silk|Opera Mini/i.test(navigator.userAgent) || $(window).width() <= 991) {
    isMobile = true;
} else isMobile = false;



$(document).ready(function () {
    $('.navMenu__active > a').on('click', function (event) {
        event.preventDefault();
    });

    $('.navMenuMobil .navMenu__active > a').on('click', function () {
        $(this).toggleClass('active');
        $('.navMenuMobilIn').slideToggle();
    });

    $('.headerBtn').on('click', function () {
        $(this).toggleClass('active');
        $('.mobilBlock').slideToggle();
    });

    $('.select').multipleSelect({});
});
