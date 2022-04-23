window.axios = require('axios');
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
window.axios.defaults.headers.common['x-apikey'] = '123456';


let langPrefix = $('html').attr('lang') === 'ru' ? '/ru' : '';
let token = $('meta[name="csrf-token"]').attr('content');

import {
    Validator
} from './modules/validator';

let isMobile;
if (/Android|webOS|iPhone|iPad|iPod|BlackBerry|BB|PlayBook|IEMobile|Windows Phone|Kindle|Silk|Opera Mini/i.test(navigator.userAgent) || $(window).width() <= 991) {
    isMobile = true;
} else isMobile = false;

$(document).ready(function () {

    // валидация форм
    let validator = new Validator();

    $('.navMenu__active > a').on('click', function (event) {
        event.preventDefault();
    });

    $('.navMenuMobil .navMenu__active > a').on('click', function () {
        $(this).toggleClass('active');
        $(this).parent().find('.navMenuMobilIn').slideToggle();
    });

    $('.headerBtn').on('click', function () {
        $(this).toggleClass('active');
        $('.mobilBlock').slideToggle();
    });

    $('.select').multipleSelect({});

    $('.scheduleList__online a').on('click', function (event) {
        event.preventDefault();
        $('.scheduleSlider').removeClass('offline');
        $(".scheduleList__offline.active, .scheduleList__offline .active").removeClass('active');
        $(this).parents('.scheduleList__online').addClass('active');
        $(this).addClass('active');
    });

    $('.scheduleList__offline').on('click', function (event) {
        event.preventDefault();
        $('.scheduleSlider').addClass('offline');
        $(".scheduleList__offline").addClass('active');
        $(".scheduleList__offline.active a").addClass('active');
        $(".scheduleList__online, .scheduleList__online a").removeClass('active');
    });
});
