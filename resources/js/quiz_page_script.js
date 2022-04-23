import { Pagination } from './modules/pagination';

$(document).ready(function () {
    let pagination = new Pagination();

    
    let container = $('[data-block="tests-intensive"]');
    if(container){
        container.find('.teachersIn:first').show();

        // общее кол-во вопросов
        let countQuestion = parseInt(container.find('.teachersIn').length);

        container.find('.formIntensive label').click(function(){
            let label = $(this);
            let input = label.find('input');
            let point = parseInt(input.val());
            let question = label.closest('.teachersIn');
            let number = question.data('number');

            // деактивация следующего вопроса
            if(parseInt(number) != countQuestion){
                question.next('.teachersIn').show();
                
                totalPoint();
            }
            else{
                // считаем сумму баллов
                totalPoint();

                container.find('#total').show();
            }
        });

        // считаем сумму баллов
        let totalPoint = function(){
            
            let total = 0;

            container.find('.formIntensive input:checked').each(function(){
                total = total + parseInt($(this).val());
            });

            container.find('#total .subtotal').text(total);
        }
    }
});