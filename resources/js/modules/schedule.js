export class Schedule{
    constructor(){
        this.filterFirstField = '';
        this.items = [];
        this._token = $('meta[name="csrf-token"]').attr("content");
        
        this.itemsWrapper = $('#home-page-block-course');
        this.paginationBlock = this.itemsWrapper.find('.pagination-block');
    }

    init(){
        this.events();

        this.getList();
    }

    events(){
        let context = this;
        
        $('#filter-form select').change(function () {
            let path = context.getPathWithFilters(
                context.generateFilters()
            );

            console.log(path);
            

            if (!path) {
                return;
            }

            context.sendAjax(
                path,
                function(data){
                    context.successFilter(context, data)
                }
            )
        });


        $('#filter-form .etabs .tab').click(function(){
            let _this = $(this);

            $('#filter-form .etabs .tab').removeClass('active');

            _this.addClass('active');

            let path = context.getPathWithFilters(
                context.generateFilters()
            );

            console.log(path);

            if (!path) {
                return;
            }

            context.sendAjax(
                path,
                function(data){
                    context.successFilter(context, data)
                }
            )

            return false;
        });
    }

    getList(){
        let context = this;

        let path = '/courses/sort=date;numbers=3/';
        context.sendAjax(
            path,
            function(data){
                context.successFilter(context, data)
            }
        )
    }

    /**
     * Generate fiters
     * @returns {{}}
     */
    generateFilters() {
        let context = this;

        let form = $('#filter-form'),
            values = form.serializeArray(),
            filters = {},
            sort = 'date',
            numbers = 3;
        // Parse filters
        $(values).each(function (index, obj) {
            if (obj.value !== '') {
                if (filters[obj.name]) {
                    filters[obj.name] += ',' + obj.value;
                } else {
                    filters[obj.name] = obj.value;
                }

                if (context.filterFirstField.length == 0) {
                    context.filterFirstField = obj.name;
                }
            }
        });

        if (parseInt(Object.keys(filters).length) == 1) {
            // первый ключ объекта
            let firstKey = function (obj) {
                for (var key in obj)
                    if (Object.getOwnPropertyDescriptor(obj, key))
                        return key;
            };

            $(filters).each(function (i, obj) {
                $(obj).each(function (code, itemValues) {
                    if (firstKey(itemValues) != 'sort' && firstKey(itemValues) != 'numbers') {
                        context.filterFirstField = firstKey(itemValues);
                    }
                });
            });
        }

        // Add sort
        if (sort) {
            filters['sort'] = sort;
        }

        // Add limit page
        if (numbers) {
            filters['numbers'] = numbers;
        }

        return filters;
    }
    
    
    // Add filters to path
    getPathWithFilters(filters) {
        let context = this;

        let targetUrl = '/';
        if(window.targetUrl){
            targetUrl = window.targetUrl;
        }
        
        let pathArray = targetUrl.split('/').filter(value => value !== ''),
            getParams = window.location.search.substr(1),
            replaceIndex = null;



        // Detect if filters are already present in path
        for (let i in pathArray) {
            if (pathArray[i].indexOf('=') !== -1) {
                pathArray[i].split(';').forEach(value => {
                    let filterArr = value.split('=');
                    if (['categories', 'text'].indexOf(filterArr[0]) !== -1) {
                        // Take filters from path and put them to new filters
                        filters[filterArr[0]] = filterArr[1];
                    }
                })
                replaceIndex = i;
            }
        }

        // Convert filters to string
        let filtersString = '';
        for (let i in filters) {
            filtersString += i + '=' + filters[i] + ';'
        }
        
        if (filtersString.length > 0 && context.filterFirstField.length > 0) {
            filtersString += 'start=' + context.filterFirstField + ';';
        }

        filtersString = filtersString.slice(0, -1);

        // Add filters to path
        if (replaceIndex) {
            if (pathArray[replaceIndex] === filtersString && (filtersString.indexOf(';') > -1)) {
                // Not attach filters if previous filters has been the same
                return;
            }
            pathArray[replaceIndex] = filtersString
        } else {
            // If current page is not catalog then put filter as main
            pathArray = [filtersString];
        }

        if (pathArray[0] != 'categories' && pathArray[0].indexOf('=') == 0) {
            pathArray.splice(0, 1);
        }

        // применяя фильтрацию перемещаемся на первую страницу
        for (let i in pathArray) {
            if (pathArray[i].indexOf('page-') !== -1) {
                pathArray.splice(i, 1);
            }
        }

        let path = pathArray.join('/');

        let category = '';
        
        let slugCat = $.trim($('#filter-form .etabs .tab.active a').attr('data-slug'));
        console.log(slugCat);
        
        if(slugCat){
            category = slugCat + '/';
        }

        path = '/courses/' + category + path


        return path + '/';
    }

    /**
     * Send ajax
     * @param path
     * @param success
     */
    sendAjax(path, success) {
        if (!path) {
            return;
        }
        $.get({
            'url': path,
            dataType: "json",
            success: success,
            error: function (data) {
                console.log('Error');
            }
        });
    }

    successFilter(context, data){

        let content = data.resource.html;
        if (content) {

            // список товаров
            context.itemsWrapper.find('.itemBlock').removeClass('empty-block').html(content);
            if(parseInt(data.resource.data.total) == 0){
                context.itemsWrapper.find('.itemBlock').addClass('empty-block');
            }


            context.itemsWrapper.find('.itemBlock .itemBottom .itemSlider').each(function(){
                $(this).slick({
                    slidesToShow: 3,
                    dots: false,
                    prevArrow: "<img src='/images/icon24.svg' class='prev' alt='1'>",
                    nextArrow: "<img src='/images/icon25.svg' class='next' alt='2'>",
                    responsive: [{
                            breakpoint: 781,
                            settings: {
                                slidesToShow: 2,
                                slidesToScroll: 1,
                            }
                        },
            
                        {
                            breakpoint: 581,
                            settings: {
                                slidesToShow: 1,
                                slidesToScroll: 1,
                            }
                        },
                    ]
                })
            });

            // пагинация
            context.paginationBlock.html(data.pagination.html);
            
        }
        else {
            context.itemsWrapper.find('.itemBlock .item').remove();
            context.itemsWrapper.find('.itemBlock .empty-catalog-text').remove();

            context.itemsWrapper.find('.itemBlock').addClass('empty-block').append('<div class="empty-catalog-text">Отсутствуют курсы выборки</div>');

            // пагинация
            context.paginationBlock.html('');
        }
    }
}
