//Add preloader
export function addPreloader(container = 'body') {
    if ($(container).find('#preloader').length != 0) {
        $(container).find('#preloader').remove();
    }
    $(`<div class='preloader' id='preloader'></div>`).appendTo(container)
}
//Remove preloader
export function removePreloader(container = 'body') {
    if ($(container).find('#preloader').length != 0) {
        $(container).find('#preloader').fadeOut();
    }
}
