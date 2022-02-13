$(document).ready(function() {

    $("#alertSuccess").hide();
    $("#alertError").hide();

});


$(function () {
    $.validator.setDefaults({
        submitHandler: function () {
            registerUser();
        }
    });
    $('#quickForm').validate({
        rules: {
            name: {
                required: true,
            },
            email: {
                required: true,
                email: true,
            },
            password: {
                required: true,
                minlength: 5
            },
            re_pass: {
                required: true,
                minlength: 5,
                equalTo: "#password"
            },
            term: {
                required: true
            },
        },
        messages: {
            name: {
                required: "Please enter a your name"
            },
            email: {
                required: "Please enter a email address",
                email: "Please enter a valid email address"
            },
            password: {
                required: "Please enter a password",
                minlength: "Your password must be at least 5 characters long"
            },
            re_pass: {
                required: "Please enter a confirm password",
                minlength: "Your password must be at least 5 characters long",
                equalTo: "Password are not matching"
            },
            term: "Please accept our terms"
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

function registerUser() {

    let data;

    var name = $('#name').val();
    var email = $('#email').val();
    var password = $('#password').val();
    var re_pass = $('#re_pass').val();

    data = {
        name: name,
        email: email,
        password: password
    }

    data = JSON.stringify(data)

    $.ajax({
        url: '../api/user/create.php',
        method: 'POST',
        processData: false,
        contentType: false,
        data: data,
        success: function (data) {
            console.log(data)
            if (data.status == 200) {
                $("#alertError").hide();
                $("#alertSuccess").text("Registration Successfully!");
                $("#alertSuccess").show();

                setTimeout(function() {
                    window.location.href = "dashboard.php";
                }, 1000);
            }else {
                $("#alertSuccess").hide();
                $("#alertError").text("This Email is already taken!");
                $("#alertError").show();
                $("#password").val(null);
                $("#re_pass").val(null);
            }
        }, error: function (request, error) {
            console.log("Request: " + JSON.stringify(request));
        }
    })

}