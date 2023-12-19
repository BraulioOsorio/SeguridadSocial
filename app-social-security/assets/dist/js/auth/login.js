(function ($) {
    $("#login_form").submit(function (e) {

        function clean() {
            $("#msg")[0].textContent = "";
            $("#form_passw, #form_correo").removeClass('is-invalid');
        }

        function handleErrors(json) {
            for (let fieldName in json.errors) {
                if (json.errors.hasOwnProperty(fieldName)) {
                    let errorMessage = json.errors[fieldName];
                    if (fieldName === "contrasenia") {
                        $("#form_passw").addClass('is-invalid');
                        $("#passw").html(errorMessage);
                    }

                    if (fieldName === "correo") {
                        $("#form_correo").addClass('is-invalid');
                        $("#email").html(errorMessage);
                    }
                }
            }
        }

        $.ajax({
            url: 'login',
            type: 'post',
            data: $(this).serialize(),
            success: function (data) {
                clean();
                let json = JSON.parse(data);
                if (json.status) {
                    window.location.href = 'inicio';
                }
            },
            statusCode: {
                400: function (err) {
                    clean();
                    let json = JSON.parse(err.responseText);
                    if (json.errors) {
                        handleErrors(json);
                    }
                },
                401: function (err) {
                    clean();
                    let json = JSON.parse(err.responseText);
                    $("#msg")[0].textContent = json.message;
                }
            }
        });
        e.preventDefault();
    });

}(jQuery))