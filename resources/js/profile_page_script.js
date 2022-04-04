$(document).ready(function () {
    $('.buyList__active a').on('click', function (event) {
        event.preventDefault();
        $(this).toggleClass('active');
        $('.buyList').toggleClass('active');
        $('.buyListIn').toggleClass('active');
      });

});







