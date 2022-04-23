
import { addPreloader, removePreloader } from './preloader';
import { initSlider } from './slider';

export class Filter {
    constructor(containerIdentif){
        this.filterFirstField = '';
        this.items = [];
        this._token = $('meta[name="csrf-token"]').attr("content");
        
        this.itemsWrapper = $('#'+containerIdentif);
        this.paginationBlock = this.itemsWrapper.find('.pagination-block');

        this.isCatalog = false;

        this.limitPage = 3;
    }

    init(){
        this.events();
    }
    
    // применяется для каталога
    setIsCatalog(){
        this.isCatalog = true;
    }

    setLimitPage(limit){
        this.limitPage = limit;
    }

    events(){
        let context = this;
        
        $('#filter-form select').change(function () {
            let path = context.getPathWithFilters(
                context.generateFilters()
            );

            if(context.isCatalog){
                history.pushState({}, null, path);
            }

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


        $('#filter-form .etabs .tab[data-action="async"]').click(function(){
            let _this = $(this);

            if(_this.hasClass('active')){
                return false;
            }

            $('#filter-form .etabs .tab').removeClass('active');

            _this.addClass('active');

            let path = context.getPathWithFilters(
                context.generateFilters()
            );

            if(context.isCatalog){
                history.pushState({}, null, path);
            }

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

    firstLoad(){
        let context = this;

        let filter = '';

        if(window.filterParams){
            for (let i in window.filterParams) {
                filter += i + '='+window.filterParams[i];
            }
            filter += ';';
        }

        let path = '/courses/'+filter+'sort=date;numbers='+context.limitPage+'/';

        if(context.isCatalog){
            history.pushState({}, null, path);
        }
        
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
            numbers = context.limitPage;

        if(window.filterParams){
            if(window.filterParams){
                for (let code in window.filterParams) {
                    if (filters[code]) {
                        filters[code] += ',' + window.filterParams[code];
                    } else {
                        filters[code] = window.filterParams[code];
                    }
                }
            }
        }
        
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
        
        addPreloader('#filter-form');

        $.get({
            'url': path,
            dataType: "json",
            success: success,
            error: function (data) {
                removePreloader('#filter-form');
            }
        });
    }

    successFilter(context, data){
        removePreloader('#filter-form');

        let content = data.resource.html;
        if (content) {

            // список товаров
            context.itemsWrapper.find('.itemBlock').removeClass('empty-block').html(content);
            if(parseInt(data.resource.data.total) == 0){
                context.itemsWrapper.find('.itemBlock').addClass('empty-block');
            }

            // переопределить фильтр
            let dataFilters = data.filters.data;
            let form = $('#filter-form');
            
            // активность элементов при применении фильтра
            $.each(dataFilters.filters, function (key, item) {
                
                let containerOptions = form.find('select[name="' + item.slug + '"]');
                
                containerOptions.find('option').attr('disabled', true);
                containerOptions.find('option[value=""]').removeAttr('disabled');

                $.each(item.options, function (k, option) {
                    var option = containerOptions.find('option[value="'+option.value+'"]');
                    option.removeAttr('disabled');
                });
            });

            $('.select').multipleSelect('destroy');
            $('.select').multipleSelect({});

            initSlider(context.itemsWrapper.find('.itemBlock .itemBottom .itemSlider'));

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
