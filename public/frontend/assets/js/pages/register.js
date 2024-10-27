document.getElementById('password').addEventListener('input', function() {
    var password = this.value;
    var strengthBar = document.getElementById('password-strength-bar');
    var strengthText = document.getElementById('password-strength-text');
    
    var strength = 0;

    if (password.length >= 8) strength += 1; 
    if (password.match(/[A-Z]/)) strength += 1; 
    if (password.match(/[0-9]/)) strength += 1;
    if (password.match(/[@$!%*#?&]/)) strength += 1;

    var color = '';
    var text = '';

    switch(strength) {
        case 0:
            color = 'danger';
            text = 'Too weak';
            strengthBar.style.width = '0%';
            break;
        case 1:
            color = 'danger';
            text = 'Weak';
            strengthBar.style.width = '25%';
            break;
        case 2:
            color = 'warning';
            text = 'Medium';
            strengthBar.style.width = '50%';
            break;
        case 3:
            color = 'info';
            text = 'Strong';
            strengthBar.style.width = '75%';
            break;
        case 4:
            color = 'success';
            text = 'Very Strong';
            strengthBar.style.width = '100%';
            break;
    }

    strengthBar.className = 'progress-bar bg-' + color;
    strengthText.innerHTML = text;
});

$(document).ready(function() {
    _formValidation();
    $('#submit').show();
    $('#submitting').hide();
})

var _formValidation = function () {
    if ($('#register-form').length > 0) {
        $('#register-form').parsley().on('field:validated', function () {
            var ok = $('.parsley-error').length === 0;
            $('.bs-callout-info').toggleClass('hidden', !ok);
            $('.bs-callout-warning').toggleClass('hidden', ok);
        });
    }

    $('#register-form').on('submit', function (e) {
        e.preventDefault();

        $('#submit').hide();
        $('#submitting').show();

        $(".ajax_error").remove();

        var submit_url = $('#register-form').attr('action');
        var formData = new FormData($("#register-form")[0]);

        //Start Ajax
        $.ajax({
            url: submit_url,
            type: 'POST',
            data: formData,
            contentType: false, // The content type used when sending data to the server.
            cache: false, // To unable request pages to be cached
            processData: false,
            dataType: 'JSON',
            success: function (data) {
                console.log(data)
                if (!data.status) {
                    if (data.validator) {
                        for (const [key, messages] of Object.entries(data.validator)) {
                            messages.forEach(message => {
                                toastr.error(message);
                            });
                        }
                    } else {
                        toastr.error(data.message);
                    }
                } else {
                    toastr.success(data.message);
                    
                    $('#register-form')[0].reset();
                    if (data.goto) {
                        setTimeout(function () {

                            window.location.href = data.goto;
                        }, 500);
                    }
                }

                $('#submit').show();
                $('#submitting').hide();
            },
            error: function (data) {
                var jsonValue = $.parseJSON(data.responseText);
                const errors = jsonValue.errors;
                if (errors) {
                    var i = 0;
                    $.each(errors, function (key, value) {
                        const first_item = Object.keys(errors)[i]
                        const message = errors[first_item][0];
                        if ($('#' + first_item).length > 0) {
                            $('#' + first_item).parsley().removeError('required', {
                                updateClass: true
                            });
                            $('#' + first_item).parsley().addError('required', {
                                message: value,
                                updateClass: true
                            });
                        }
                        // $('#' + first_item).after('<div class="ajax_error" style="color:red">' + value + '</div');
                        toastr.error(value);
                        i++;

                    });
                } else {
                    toastr.warning(jsonValue.message);
                }

                $('#submit').show();
                $('#submitting').hide();
            }
        });
    });
};