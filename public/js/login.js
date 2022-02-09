$("#login").click(function (e) {

    e.preventDefault();

    let data;

    var email = $('#email').val();
    var password = $('#password').val();

    if (email == "" || password == "") {
        console.log('if')
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


    } else {

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
                // if (data.status == 200){
                //     window.location.href = "dashboard.php";
                // }else {
                //
                // }
            }, error: function (request, error) {
                console.log("Request: " + JSON.stringify(error));
            }
        })

    }

});