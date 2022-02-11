$(document).ready(function() {

    $("#alertSuccess").hide();
    $("#alertError").hide();
    $("#alertWarning").hide();

});


$(function () {
    $.validator.setDefaults({
        submitHandler: function () {
            loginUser();
        }
    });
    $('#quickForm').validate({
        rules: {
            email: {
                required: true,
                email: true,
            },
            password: {
                required: true,
                minlength: 5
            }
        },
        messages: {
            email: {
                required: "Please enter a email address",
                email: "Please enter a valid email address"
            },
            password: {
                required: "Please enter a password",
                minlength: "Your password must be at least 5 characters long"
            }
        },
        errorElement: 'span',
        errorPlacement: function (error, element) {
            error.addClass('invalid-feedback');
            element.closest('.form-group').append(error);
        },
        highlight: function (element, errorClass, validClass) {
            $(element).addClass('is-invalid');
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).removeClass('is-invalid');
        }
    });
});

function loginUser() {

    let data;

    var email = $('#email').val();
    var password = $('#password').val();

    data = {
        email: email,
        password: password
    }

    data = JSON.stringify(data)

    $.ajax({
        url: '../api/user/read.php',
        method: 'POST',
        processData: false,
        contentType: false,
        data: data,
        success: function (data) {
            console.log(data)
            if (data.status == 200){
                $("#alertError").hide();
                $("#alertWarning").hide();
                $("#alertSuccess").text("login Successfully !");
                $("#alertSuccess").show();

                setTimeout(function() {
                    window.location.href = "pages/dashboard.php";
                }, 1000);

            }else if (data.status == 201) {
                $("#alertSuccess").hide();
                $("#alertWarning").hide();
                $("#alertError").text("Email or Password incorrect !");
                $("#alertError").show();
                $("#password").val(null);

            }else {
                $("#alertSuccess").hide();
                $("#alertWarning").hide();
                $("#alertWarning").text("Please Register Our System !");
                $("#alertWarning").show();
                $("#email").val(null);
                $("#password").val(null);

                setTimeout(function() {
                    window.location.href = "pages/register.php";
                }, 2000);
            }
        }, error: function (request, error) {
            console.log("Request: " + JSON.stringify(error));
        }
    })
}