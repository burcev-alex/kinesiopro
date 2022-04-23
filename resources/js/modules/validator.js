import { addPreloader, removePreloader } from './preloader';

export class Validator {
    constructor() {
        this._token = $('meta[name="csrf-token"]').attr("content");

        this.events();
    }

    events() {
        let context = this;

        // Форма изменение персональных данных
        context.formValidator('profileUpdate', function (form) {
            addPreloader();

            let formData = new FormData($(form).get(0));
            
            $.post({
                url: $(form).attr('action'),
                data: formData,
                contentType: false,
                processData: false,
                headers: {
                    'X-CSRF-TOKEN': context._token
                },
                success: function (response) {
                    removePreloader();
                    console.log(response);

                    document.location = '/profile/';
                    
                },
                error: function (response) {
                    removePreloader();

                    if (response.status === 422) {
                        context.showValidationErrors(form, response.responseJSON.errors);                    
                    } else {
                        console.error(response.responseJSON.message);
                    }
                }
            });
        });

        // Форма регистрации
        context.formValidator('registrationStaticForm', function (form) {
            addPreloader();

            let formData = new FormData($(form).get(0));
            
            $.post({
                url: $(form).attr('action'),
                data: formData,
                contentType: false,
                processData: false,
                headers: {
                    'X-CSRF-TOKEN': context._token
                },
                success: function (response) {
                    removePreloader();
                    console.log(response);

                    document.location = '/';
                    
                },
                error: function (response) {
                    removePreloader();

                    if (response.status === 422) {
                        context.showValidationErrors(form, response.responseJSON.errors);                    
                    } else {
                        console.error(response.responseJSON.message);
                    }
                }
            });
        });

        // авторизация
        context.formValidator('autorization', function (form) {
            addPreloader();

            $.post({
                url: $(form).attr('action'),
                data: $(form).serializeArray(),
                headers: {
                    'X-CSRF-TOKEN': context._token
                },
                success: function (response) {
                    removePreloader();

                    document.location = "/";
                    
                },
                error: function (response) {
                    removePreloader();
                    if (response.status === 422) {
                        context.showSimpleErrors(form, response.responseJSON.errors);
                    } else {
                        console.error(response.responseJSON.message);
                    }
                }
            });
        });

        // восстановление пароля
        context.formValidator('passwordFogot', function (form) {
            addPreloader();
            
            $.post({
                url: $(form).attr('action'),
                data: $(form).serializeArray(),
                headers: {
                    'X-CSRF-TOKEN': context._token
                },
                success: function (response) {
                    removePreloader();

                    console.log(response);
                    alert(response.message);
                    
                },
                error: function (response) {
                    removePreloader();
                    if (response.status === 422) {
                        context.showSimpleErrors(form, response.responseJSON.errors);
                    } else {
                        console.error(response.responseJSON.message);
                    }
                }
            });
        });

        // сброс пароля
        context.formValidator('passwordReset', function (form) {
            addPreloader();
            
            $.post({
                url: $(form).attr('action'),
                data: $(form).serializeArray(),
                headers: {
                    'X-CSRF-TOKEN': context._token
                },
                success: function (response) {
                    removePreloader();

                    console.log(response);
                    
                    document.location = '/';
                    
                },
                error: function (response) {
                    removePreloader();
                    if (response.status === 422) {
                        context.showSimpleErrors(form, response.responseJSON.errors);
                    } else {
                        console.error(response.responseJSON.message);
                    }
                }
            });
        });
    }

    formValidator(formName, handler) {
        $('#' + formName).validate({
            rules: {
                password: {
                    required: true,
                    minlength: 6
                },
                password_again: {
                    equalTo: "#password"
                },
                new_password: {
                    equalTo: "#new_password"
                },
                password_confirmation: {
                    equalTo: "#password_confirmation"
                },
                password_confirmation: {
                    equalTo: "#password"
                },
                email: {
                    required: true,
                    email: true
                },
                name: {
                    required: true
                },
                firstname: {
                    required: true
                },
                comment_area: {
                    required: true
                },
                surname: {
                    required: true
                },
                phone: {
                    required: true
                },
                telephon: {
                    required: true
                },
                recovery: {
                    required: true
                },
                work: {
                    required: true
                }
            },
            messages: {
                password: {
                    minlength: "*Минимум 6 символов",
                    required: "*Введите пароль"
                },
                password_again: {
                    equalTo: "Пароли не совпадают"
                },
                password_confirm: {
                    equalTo: "Пароли не совпадают"
                },
                password_confirmation: {
                    equalTo: "Пароли не совпадают"
                },
                public_offer: {
                    required: ""
                },
                privacy_policy: {
                    required: ""
                },
                email: {
                    required: "* Введите e-mail",
                    email: "* Введите корректный e-mail"
                },
                name: {
                    required: "* Введите имя"
                },
                firstname: {
                    required: "* Введите имя"
                },
                surname: {
                    required: "* Введите Фамилию"
                },
                recovery: {
                    required: "* Введите e-mail или номер телефона"
                },
                comment_area: {
                    required: "* Необходимо добавить комментарий"
                },
                middle_name: {
                    required: "* Введите Отчество"
                },
                phone: {
                    required: "* Введите телефон"
                },
                telephon: {
                    required: "* Введите телефон"
                },
                work: {
                    required: "* Введите место работы"
                }
            },
            submitHandler: function submitHandler(form) {
                handler(form);
            },
            errorElement: 'span'
        });
    }
    
    /**
     * Block button
     * @param button
     */
    blockButton(button) {
        $(button).prop('disabled', true);
    }
    
    /**
     * Unblock button
     * @param button
     */
    unblockButton(button) {
        $(button).prop('disabled', false);
    }
    
    // Show error for form element
    showValidationErrors(form, errors) {
        $(form).find('input, textarea').each(function (key, input) {
            let fieldName = $(input).attr('name'),
                errorBlock = $('#' + fieldName + '-error');
            if (errors[fieldName]) {
                if (errorBlock.length !== 0) {
                    errorBlock.css('display', 'block');
                    errorBlock.text(errors[fieldName][0]);
                } else {
                    $(input).closest('label').append('<span id="' + fieldName + '-error" class="error">' + errors[fieldName][0] + '</span>')
                    $(input).click(function (e) {
                        // Add event to remove error
                        $(this).closest('label').find('#' + fieldName + '-error').remove();
                        $(this).unbind('click');
                    })
                }
            } else if (errorBlock.length !== 0) {
                errorBlock.text('');
            }
        })
    }
    
    showSimpleErrors(form, errors){
        $(form).find('input, textarea').each(function (key, input) {
            let fieldName = $(input).attr('name'),
                errorBlock = $('#' + fieldName + '-error');
                
            if (errors[fieldName]) {
                if (errorBlock.length !== 0) {
                    errorBlock.css('display', 'block');
                    errorBlock.text(errors[fieldName]);
                } else {
                    $(input).after('<span id="' + fieldName + '-error" class="error">' + errors[fieldName] + '</span>')
                    $(input).click(function (e) {
                        // Add event to remove error
                        $(this).find('#' + fieldName + '-error').remove();
                        $(this).unbind('click');
                    })
                }
            } else if (errorBlock.length !== 0) {
                errorBlock.text('');
            }
        })
    }
}