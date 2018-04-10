"use strict";

import $ from 'jquery';

// enables jquery visibility in the current scope
window.jQuery = $;
window.$ = $;

function validateEmail(email) {
    const re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(String(email).toLowerCase());
}

function validateName(name) {
    if (typeof name !== "string") {
        return false;
    }

    return name.length >= 3;
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
    const nameField = $('input[name=name]');
    const emailRegisterField = $('#form-register input[type=email]');
    const passwordMessage = $('#password-info-message');

    // noinspection JSUnresolvedVariable
    const confirmExists = passwordConfirmField.length > 0;

    nameField.keyup(function () {
        const elem = $(this);
        const value = elem.val();

        if (validateName(value)) {
            elem.validate();
        } else {
            elem.invalidate();
        }
    });

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
        const thisField = $(this);
        const value = thisField.val();

        const alphanumerical = /^[a-zA-Z0-9]+$/g;
        const hasLowerCase = /[a-z]+/g;
        const hasUpperCase = /[A-Z]+/g;
        const hasDigit = /[0-9]+/g;

        const minLength = 8;

        function validationFailed(text) {
            thisField.invalidate();
            passwordMessage.text(text);
        }

        if (value.length < minLength) {
            validationFailed(`Password must be at least ${minLength} characters long`);
            return;
        }

        if (!alphanumerical.test(value)) {
            validationFailed("Password must only contain alphanumerical characters.");
            return;
        }

        if (!hasLowerCase.test(value)) {
            validationFailed("Password must contain a lowercase character.");
            return;
        }

        if (!hasUpperCase.test(value)) {
            validationFailed("Password must contain a uppercase character.");
            return;
        }

        if (!hasDigit.test(value)) {
            validationFailed("Password must contain a digit.");
            return;
        }

        if (confirmExists) {
            if (passwordConfirmField.val().length > 0) {
                if (passwordField.val() !== passwordConfirmField.val()) {
                    passwordConfirmField.invalidate();
                    validationFailed("Passwords do not match.");
                } else {
                    passwordMessage.text("Password match!");
                    passwordMessage.validate();
                    thisField.validate();
                    passwordConfirmField.validate();
                }
            } else {
                passwordMessage.text("");
                thisField.validate();
            }
        } else {
            thisField.validate();
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