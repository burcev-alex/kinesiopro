import { Pagination } from './modules/pagination';

$(document).ready(function () {
    let pagination = new Pagination();

    if(window.podcastIdentifMark){
        VK.Widgets.Podcast("vk_podcast", window.podcastIdentifMark, {});
    }
});







