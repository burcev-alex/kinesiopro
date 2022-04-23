import { addPreloader, removePreloader } from './preloader';

export class Checkout {
    constructor() {
        this._token = $('meta[name="csrf-token"]').attr("content");

        this.events();
    }

    events() {
        let context = this;

        // Валидация форм
        $('#createOrder[data-action="async"]').on('submit', function (e) {
            e.preventDefault();
            
            let container = $(this);
            let button = $(this).find('input[type="submit"]');

            addPreloader()

            $.post({
                url: $(this).attr('action'),
                data: $(this).serializeArray(),
                headers: {
                    'X-CSRF-TOKEN': context._token
                },
                success: function (response) {
                    removePreloader();

                    container.find('.errors').hide().html('');
                    
                    console.log(response);

                    window.open(response.data.external.url, '_blank');
					window.focus();

                    alert('Заказ успешно создан!');
                    
                },
                error: function (err) {
                    removePreloader();
                    
                    let result = err.responseJSON;
					if (!result.success) {
						let messages = [];
						
                        if(Array.isArray(result.data)){
                            for(var key in result.data){
                                messages.push(result.data[key][0])
                            }
                        }
                        else{
                            messages.push(result.data);
                        }
						
                        container.find('.errors').show().html(messages.join('<br/>'));
					}
                    
                }
            })
        });
    }
}