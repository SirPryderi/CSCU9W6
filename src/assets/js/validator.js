"use strict";

import $ from 'jquery';

// enables jquery visibility in the current scope
window.jQuery = $;
window.$ = $;

function validateEmail(email) {
    const re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(String(email).toLowerCase());
}

$.fn.validate = function () {
    this.addClass('is-valid');
    this.removeClass('is-invalid');
    return this;
};

$.fn.invalidate = function () {
    this.addClass('is-invalid');
    this.removeClass('is-valid');
    return this;
};

$(() => {
    const passwordConfirmField = $('input.password-confirm');
    const passwordField = $('input[type=password]');
    const emailField = $('input[type=email]');
    const emailRegisterField = $('#form-register input[type=email]');
    const passwordMessage = $('#password-info-message');

    const confirmExists = passwordConfirmField.length > 0;

    emailField.keyup(function () {
        const elem = $(this);
        const value = elem.val();

        if (validateEmail(value)) {
            elem.validate();
        } else {
            elem.invalidate();
        }
    });

    passwordField.keyup(function () {
        const elem = $(this);
        const value = elem.val();

        const number = 2;

        if (value.length > number) {
            elem.validate();
            passwordMessage.text(`Nice password!`);
        } else {
            elem.invalidate();
            passwordMessage.text(`Password must be at least ${number} characters long`);
            return;
        }

        if (confirmExists && passwordConfirmField.val().length > 0) {
            if (passwordField.val() !== passwordConfirmField.val()) {
                passwordField.invalidate();
                passwordConfirmField.invalidate();
                passwordMessage.text(`Passwords do not match.`);
            } else {
                passwordMessage.text("Password match!");
                passwordMessage.validate();
                passwordField.validate();
                passwordConfirmField.validate();
            }
        }
    });


    let wto;

    emailRegisterField.keyup(function () {
        const field = $(this);

        clearTimeout(wto);

        wto = setTimeout(function () {
            if (field.hasClass('is-valid')) {
                $.post({
                    type: "POST",
                    url: '/rest/',
                    data: {
                        action: 'user-exists',
                        email: field.val()
                    },
                    success: function (data) {
                        const error = "User already exists!";

                        if (data['user-exists'] === true) {
                            field.addClass('is-invalid');

                            passwordMessage.text(error);
                        } else if (passwordMessage.text() === error) {
                            passwordMessage.text("");
                        }
                    }
                });
            }
        }, 500);
    });

});