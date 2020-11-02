/**
 * @param data.regFlag
 * @param data.errors
 * @param data.auth
 * @param data.loginInvalid
 * @param data.emailInvalid
 * @param data.codeOriginal
 * @param data.msg
 * @param data.change
 */
$(function() {
    let codeOriginal = "";

    //Очистка форм при регистрации
    $("#clearForm").on('click', function (e) {
        e.preventDefault();
        $("#form-singin")[0].reset();
    });

    //Ошибки AJAX
    $.ajaxSetup({
        error: function (x, status, error) {
            alert("An error occurred: " + status + " Error: " + error);}
    });

    //Регистрация
    $("#form-singin").on('submit', function (e) {
        e.preventDefault();
        let name = $("#name").val();
        let email = $("#email").val();
        let login = $("#login").val();
        let password = $("#password").val();
        let passwordRep = $("#passwordRep").val();
        $.ajax({
            method: "POST",
            url: "singin.php",
            dataType: "json",
            data: {
                name: name,
                email: email,
                login: login,
                password: password,
                passwordRep: passwordRep
            },
            error: function (data) {
                alert('err: no ajax: ' + data);
            },
            success: function (data) {
                if(data.regFlag === 'yep'){
                    alert("Добро пожаловать, "+login);
                    location.href = 'index.html';
                } else {
                    alert(data.errors);
                }
            }
        })
    });

    //Авторизация
    $("#form-auth").on('submit', function (e) {
        e.preventDefault();
        let login = $("#login").val();
        let password = $("#password").val();
        let session = $("#rememberMe").is(':checked');
        $.ajax({
            method: "POST",
            url: "index.php",
            dataType: "json",
            data: {
                login: login,
                password: password,
                session: session
            },
            error: function (data) {
                alert('err: no ajax: ' + data);
            },
            success: function (data) {
                if (data.auth === true) {
                    alert("Добро пожаловать, "+login);
                    location.href = 'home.html';
                } else {
                    alert("Неправильный логин или пароль");
                }
            }
        })
    });

    //Отправка кода для восстановления пароля
    $("#sendCode").on('click', function (e) {
        e.preventDefault();
        let login = $("#login").val();
        let email = $("#email").val();
        $.ajax({
            method: "POST",
            url: "recovery.php",
            dataType: "json",
            data: {
                login: login,
                email: email
            },
            error: function (data) {
                alert("no ajax: " + data);
            },
            success: function (data) {

            }
        }).done(function (response) {
            if (!response.loginInvalid && !response.emailInvalid) {
                $("#stage-two").attr("style", "");
                alert("Ваш код для восстаовления пароля: " + response.codeOriginal);
                codeOriginal = response.codeOriginal;
            } else {
                if (response.loginInvalid) {
                    alert("Логин не найден");
                    $("#stage-two").attr("style", "display: none");
                }
                if (response.emailInvalid) {
                    alert("Почта не найдена");
                    $("#stage-two").attr("style", "display: none");
                }
            }
        });
    });

    //Отправка кода для восстановления пароля
    $("#sendCode").on('click', function (e) {
        e.preventDefault();
        let login = $("#login").val();
        let email = $("#email").val();
        $.ajax({
            method: "POST",
            url: "rec.php",
            dataType: "json",
            data: {
                login: login,
                email: email
            },
            error: function (data) {
                alert("no ajax: " + data);
            },
            success: function (data) {
                if (!data.loginInvalid && !data.emailInvalid) {
                    $("#stage-two").attr("style", "");
                    alert("Ваш код для восстаовления пароля: " + data.codeOriginal);
                    codeOriginal = data.codeOriginal;
                } else {
                    if (data.loginInvalid) {
                        alert("Логин не найден");
                        $("#stage-two").attr("style", "display: none");
                    }
                    if (data.emailInvalid) {
                        alert("Почта не найдена");
                        $("#stage-two").attr("style", "display: none");
                    }
                }
            }
        })
    });

    //Подтверждение кода для восстановления пароля
    $("#confirmCode").on('click', function (e) {
        e.preventDefault();
        let codeInput = $("#code").val();
        if (codeInput === codeOriginal) {
            $("#stage-three").attr("style", "");
        } else {
            alert("Неправильный код");
            $("#stage-two").attr("style", "display: none");
        }
    })

    //Изменение пароля
    $("#form-recovery").on('submit', function (e) {
        e.preventDefault();
        let login = $("#login").val();
        let password = $("#password").val();
        let passwordRep = $("#passwordRep").val();
        $.ajax({
            method: "POST",
            url: "password_change.php",
            dataType: "json",
            data: {
                login: login,
                password: password,
                passwordRep: passwordRep
            },
            error: function (data) {
                alert("err ajax: " + data);
            },
            success: function (data) {
                if (data.change === 'yep') {
                    alert('Пароль успешно измененн');
                    location.href = 'index.html';
                } else {
                    alert(data.msg);
                }
            }
        })
    });
});