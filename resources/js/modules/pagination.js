export class Pagination {
    constructor() {
        this._token = $('meta[name="csrf-token"]').attr("content");

        this.events();
    }

    events() {
        let context = this;

        $(document).on('click', 'a[data-action="async"]', function (e) {
            e.preventDefault();
            let that = this;
            $(that).addClass('loading');

            let url = $(this).attr('href'),
                itemsBlock = $('#' + $(this).data('block')),
                paginationBlock = $(this).closest('.pagination-block');

            if (itemsBlock.length === 0) {
                console.error('Items block not found for loading items');
            }

            if (window.targetUrl) {
                url = url.split(window.location.pathname).join('/' + window.targetUrl + '/');
            }

            $.get({
                cache: false,
                'url': url + '?ajax=1',
                dataType: "json",
                success: function (data) {
                    $(that).removeClass('loading');
                    let content = data.resource.html;
                    if (content) {
                        // список
                        itemsBlock.removeClass('empty-block').append(data.resource.html);
                        if (Object.keys($(content)).length == 0) {
                            itemsBlock.addClass('empty-block');
                        }


                        paginationBlock.html(data.pagination.html);
                    } else {
                        itemsBlock.addClass('empty-block').append('<li class="empty-catalog-text">Отсутствуют позиции выборки</li>');
                        paginationBlock.html('');
                    }
                },
                error: function (data) {
                    $(that).removeClass('loading');
                    console.log('Error');
                }
            });
        });
    }
}
