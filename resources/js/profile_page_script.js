$(document).ready(function () {
    $('.buyList__active a').on('click', function (event) {
        event.preventDefault();
        $(this).toggleClass('active');
        $('.buyList').toggleClass('active');
        $('.buyListIn').toggleClass('active');
      });

    $('a[data-action="change-data-user"]').on('click', function(){

        $(this).closest('.accountCenterRed').hide();
        $('#accountInfoShow').hide();
        $('#profileUpdate').show();
        return false;
    });
});







