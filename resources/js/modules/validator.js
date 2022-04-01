import { addPreloader, removePreloader } from './preloader';

// Валидатор
export function formValidator(formName, handler) {
    $('#' + formName).validate({
        rules: {
            password: {
                required: true,
                minlength: 6
            },
            password_again: {
                equalTo: "#password"
            },
            password_confirm: {
                equalTo: "#new_password"
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
export function blockButton(button) {
    $(button).prop('disabled', true);
}

/**
 * Unblock button
 * @param button
 */
 export function unblockButton(button) {
    $(button).prop('disabled', false);
}

// Show error for form element
export function showValidationErrors(form, errors) {
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

// Валидация форм
$(document).on('click', '.sendFormBtn', function (e) {
    // e.preventDefault();
    let formID = $(this).closest('form').attr('id'),
        button = $(this);
    formValidator(formID, function (form) {
        if (formID == 'passwordRecoveryForm' ||
            formID == 'registrationStaticForm') {
            addPreloader()
        }
        // After form passed validation
        blockButton(button);
        $.post({
            url: $(form).attr('action'),
            data: $(form).serializeArray(),
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) {
                removePreloader();
                console.log(response);
                unblockButton(button);

                document.location = '/';
                
            },
            error: function (response) {
                removePreloader();
                if (formID == 'passwordRecoveryForm') {
                    removePreloader();
                    if (response.status === 422) {
                        console.log('response error', response)
                        $('.modal-form .help-text').text(response.responseJSON.errors['email']);
                        $('.recovery-input').addClass('error');
                        $('.modal-form .help-text').addClass('show error');
                        unblockButton(button);
                    }

                }

                if (response.status === 422 && formID != 'passwordRecoveryForm') {
                    showValidationErrors(form, response.responseJSON.errors);
                } else {
                    console.error(response.responseJSON.message);
                }
                unblockButton(button)
            }
        })
    })
})